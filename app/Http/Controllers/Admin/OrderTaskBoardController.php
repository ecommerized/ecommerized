<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClientOrderTaskBoardRequest;
use App\Models\ClientOrderItem;
use App\Models\FileManager;
use App\Models\Label;
use App\Models\OrderTask;
use App\Models\OrderTaskAssignee;
use App\Models\OrderTaskAttachment;
use App\Models\OrderTaskConversation;
use App\Models\OrderTaskConversationSeen;
use App\Models\OrderTaskRequirement;
use App\Models\User;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class OrderTaskBoardController extends Controller
{
    use ResponseTrait;

    public function list($order_item_id)
    {
        $data['pageTitle'] = __('Order Task');
        $data['activeClientOrderIndex'] = 'active';
        $userId = auth()->id();
        $userRole = auth()->user()->role;

        $data['teamMember'] = User::where(['role' => USER_ROLE_TEAM_MEMBER])->get();
        $data['orderItem'] = ClientOrderItem::where(['id' => $order_item_id])->with(['order.client', 'order.plan', 'service'])->first();
        $data['labels'] = Label::all();

        $orderTasksQuery = OrderTask::where(['client_order_item_id' => $order_item_id])
            ->with(['assignees.user', 'requirement', 'labels']);

        if ($userRole == USER_ROLE_CLIENT) {
            $orderTasksQuery->where('client_access', 1);
        } elseif ($userRole == USER_ROLE_TEAM_MEMBER) {
            $orderTasksQuery->join('order_task_assignees', 'order_tasks.id', '=', 'order_task_assignees.order_task_id')
                ->where('order_task_assignees.assign_to', $userId)
                ->whereNull('order_task_assignees.deleted_at')
                ->select('order_tasks.*');
        }

        $data['orderTasks'] = $orderTasksQuery->get();

        $assigneeList = [];
        if ($data['orderItem'] != null) {
            foreach ($data['orderItem']->assignee as $key => $assignee) {
                $assigneeList[$key] = $assignee->assigned_to;
            }
        }
        $data['orderAssignee'] = $assigneeList;

        return view('admin.orders.task-board.list', $data);
    }

    public function store(ClientOrderTaskBoardRequest $request, $order_item_id, $id = null)
    {
        try {
            DB::beginTransaction();

            $orderItem = ClientOrderItem::where(['id' => $order_item_id])->first();

            // Determine if this is a create or update operation
            $orderTask = $id ? OrderTask::find($id) : new OrderTask;
            $isUpdate = $id ? true : false;

            // Set common attributes
            $orderTask->task_name = $request->task_name;
            $orderTask->client_order_id = $orderItem->client_order_id;
            $orderTask->client_order_item_id = $order_item_id;
            $orderTask->description = $request->description;
            $orderTask->start_date = $request->start_date;
            $orderTask->end_date = $request->end_date;
            $orderTask->priority = $request->priority;
            $orderTask->client_access = $request->has_client_access ? 1 : 0;
            $orderTask->created_by = $isUpdate ? $orderTask->created_by : auth()->id();
            $orderTask->status = $request->status;

            // Save or update the task
            $orderTask->save();

            // Generate a unique taskBoard ID if this is a new task
            if (!$isUpdate) {
                $orderTask->taskId = generateUniqueTaskboardId($orderTask->id);
                $orderTask->save();
            }

            // Handle file uploads
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $newFile = new FileManager();
                    $uploaded = $newFile->upload('attachments', $file);

                    if (!is_null($uploaded)) {
                        $orderTask->attachments()->create([
                            'file' => $uploaded->id,
                            'order_task_id' => $orderTask->id,
                        ]);
                    } else {
                        DB::rollBack();
                        return $this->error([], __('Something went wrong with the file upload.'));
                    }
                }
            }

            // Extract label names from the request
            $labelNames = $request->labels;

            // Find or create labels and collect their IDs
            $labelIds = collect($labelNames)->map(function ($labelName) {
                $label = Label::firstOrCreate(['name' => $labelName]);
                return $label->id;
            });

            // Sync the label IDs to the orderTask->labels relationship
            $orderTask->labels()->sync($labelIds);

            // Handle assignees
            if ($request->assign_member) {
                $assignMemberIds = $request->assign_member;

                // Get current assignees
                $currentAssignees = $orderTask->assignees->pluck('assign_to')->toArray();

                // Determine assignees to delete and to add
                $assigneesToDelete = array_diff($currentAssignees, $assignMemberIds);
                $assigneesToAdd = array_diff($assignMemberIds, $currentAssignees);

                // Delete the assignees that are no longer assigned
                OrderTaskAssignee::where('order_task_id', $orderTask->id)
                    ->whereIn('assign_to', $assigneesToDelete)
                    ->delete();

                // Add the new assignees
                foreach ($assigneesToAdd as $userId) {
                    OrderTaskAssignee::create([
                        'order_task_id' => $orderTask->id,
                        'assign_to' => $userId,
                        'assign_by' => auth()->id(),
                    ]);
                }
            }

            DB::commit();
            return $this->success([], $isUpdate ? __('Updated Successfully') : __('Added Successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error([], __('Something went wrong, please try again'));
        }
    }

    public function updateStatus(Request $request, $order_item_id)
    {
        try {
            $task = OrderTask::where('id', $request->task_id)
                ->where('client_order_item_id', $order_item_id)
                ->first();

            $task->status = $request->new_status;
            $task->save();
            return $this->success();
        } catch (\Exception $e) {
            return $this->error([], __('Something went wrong! Please try again'));
        }

    }

    public function edit($order_item_id, $id)
    {
        $data['orderTask'] = OrderTask::where('id', $id)
            ->where('client_order_item_id', $order_item_id)
            ->with(['assignees.user', 'labels', 'order'])
            ->first();

        $data['teamMember'] = User::where(['role' => USER_ROLE_TEAM_MEMBER])->get();
        $data['labels'] = Label::all();
        $data['orderItem'] = $data['orderTask']->client_order_item;

        $assigneeList = [];
        if ($data['orderItem'] != null) {
            foreach ($data['orderItem']->assignee as $key => $assignee) {
                $assigneeList[$key] = $assignee->assigned_to;
            }
        }
        $data['orderAssignee'] = $assigneeList;

        return view('admin.orders.task-board.edit', $data)->render();
    }

    public function delete($order_item_id, $id)
    {
        try {
            OrderTask::where('id', $id)
                ->where('client_order_item_id', $order_item_id)
                ->delete();
            return $this->success([], __('Deleted Successfully'));
        } catch (\Exception $e) {
            return $this->error([], __('Something went wrong! Please try again'));
        }
    }

    public function view($order_item_id, $id)
    {
        $data['orderTask'] = OrderTask::where('id', $id)
            ->where('client_order_item_id', $order_item_id)
            ->with(['assignees.user', 'labels', 'order', 'client_order_item', 'attachments.filemanager'])
            ->first();

        $data['orderItem'] = $data['orderTask']->client_order_item;
        $data['conversationClientTypeData'] = OrderTaskConversation::where(['order_task_id' => $id, 'type' => CONVERSATION_TYPE_CLIENT])->with('user')->get();
        $data['conversationTeamTypeData'] = OrderTaskConversation::where(['order_task_id' => $id, 'type' => CONVERSATION_TYPE_TEAM])->with('user')->get();

        return view('admin.orders.task-board.view', $data)->render();
    }

    public function uploadRequirementModal($order_item_id, $id)
    {
        $data['orderTask'] = OrderTask::where('id', $id)
            ->where('client_order_item_id', $order_item_id)
            ->with(['requirement', 'client_order_item.service'])
            ->first();

        $data['orderTaskRequirement'] = $data['orderTask']->requirement;
        $data['orderItem'] = $data['orderTask']->client_order_item;

        return view('admin.orders.task-board.upload_requirement', $data)->render();
    }

    public function uploadRequirement(Request $request, $order_item_id, $id)
    {
        $request->validate([
            'description' => 'required|min:30',
            'attachments.*' => 'bail|nullable|mimes:csv,odt,doc,docx,htm,html,pdf,ppt,pptx,txt,xls,xlsx,jpg,jpeg,png,gif,webp,svg,ai,mp4,mp3,wav,zip,rar',
        ], [
            'attachments.*.mimes' => __('The file must be a valid format, check the (i) icon.')
        ]);

        try {
            $orderTask = OrderTask::where('id', $id)
                ->where('client_order_item_id', $order_item_id)
                ->with(['requirement'])
                ->first();

            $file = [];
            if ($request->attachment && $request->oldFiles) {
                $fileId = [];
                foreach ($request->attachment as $singleFile) {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('requirements', $singleFile);
                    array_push($fileId, (string)$uploaded->id);
                }
                $fileArray =  array_merge($request->oldFiles, $fileId);
                $file = json_encode($fileArray);

            }else if($request->attachment && !$request->oldFiles){
                $fileId = [];
                foreach ($request->attachment as $singleFile) {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('ticket-documents', $singleFile);
                    array_push($fileId, $uploaded->id);
                }
                $file = json_encode($fileId);
            }else if(!$request->attachment && $request->oldFiles){
                $file = json_encode($request->oldFiles);
            }

            OrderTaskRequirement::updateOrCreate([
                'order_task_id' => $id
            ], [
                'order_task_id' => $id,
                'client_order_id' => $orderTask->client_order_id,
                'client_order_item_id' => $order_item_id,
                'description' => $request->description,
                'file' => $file
            ]);

            return $this->success([], __('Saved Successfully'));

        } catch (\Exception $e) {
            return $this->error([], __('Something went wrong! Please try again'));
        }
    }

    public function viewRequirement($order_item_id, $id)
    {
        $data['orderTask'] = OrderTask::where('id', $id)
            ->where('client_order_item_id', $order_item_id)
            ->with(['requirement', 'client_order_item.service'])
            ->first();

        $data['orderTaskRequirement'] = $data['orderTask']->requirement;
        $data['orderItem'] = $data['orderTask']->client_order_item;

        return view('admin.orders.task-board.view_requirement', $data)->render();
    }

    public function deleteAttachment($order_item_id, $task_id, $id)
    {
        OrderTaskAttachment::where(['order_task_id' => $task_id, 'file' => $id])->delete();
        return $this->success([], __('Deleted Successfully'));
    }

    public function changeProgress(Request $request, $order_item_id, $id)
    {
        OrderTask::where(['client_order_item_id' => $order_item_id, 'id' => $id])->update(['progress' => $request->progress]);
        return $this->success([], __('Progress Update Successfully'));
    }

    public function conversationStore(Request $request, $order_item_id, $id)
    {
        $request->validate([
            'conversation_text' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $dataObj = new OrderTaskConversation();
            $dataObj->order_task_id = $id;
            $dataObj->conversation_text = $request->conversation_text;
            $dataObj->type = $request->type;
            $dataObj->user_id = auth()->id();

            /*File Manager Call upload*/
            if ($request->file) {
                $fileId = [];
                foreach ($request->file as $singleFile) {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('ticket-conversation-documents', $singleFile);
                    array_push($fileId, $uploaded->id);
                }
                $dataObj->attachment = json_encode($fileId);
            }
            /*File Manager Call upload*/

            $dataObj->save();
            DB::commit();

            $renderData['conversationClientTypeData'] = OrderTaskConversation::where(['order_task_id' => $id, 'type' => CONVERSATION_TYPE_CLIENT])->with('user')->get();
            $renderData['conversationTeamTypeData'] = OrderTaskConversation::where(['order_task_id' => $id, 'type' => CONVERSATION_TYPE_TEAM])->with('user')->get();
            $renderData['type'] = $request->type;

            if (auth()->user()->role == USER_ROLE_CLIENT) {
                $data['conversationClientTypeData'] = view('user.orders.task-board.conversation_list_render', $renderData)->render();
            } else {
                $data['conversationClientTypeData'] = view('user.orders.task-board.conversation_list_render', $renderData)->render();
                $data['conversationTeamTypeData'] = view('admin.orders.task-board.conversation_list_render', $renderData)->render();
            }
            $data['type'] = $request->type;

            OrderTaskConversationSeen::where('order_task_id', $id)
                ->where('created_by', '!=', auth()->id())
                ->update(['is_seen' => 0]);

            OrderTask::where(['id' => $id])
                ->update([
                    'last_reply_id' => $dataObj->id,
                    'last_reply_by' => auth()->id(),
                    'last_reply_time' => now(),
                ]);

            return $this->success($data, __(CREATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], $e->getMessage());
        }
    }

}
