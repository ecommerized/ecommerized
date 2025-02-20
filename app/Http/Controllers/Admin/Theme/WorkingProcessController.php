<?php

namespace App\Http\Controllers\Admin\Theme;

use App\Http\Controllers\Controller;
use App\Models\FileManager;
use App\Models\WorkingProcess;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkingProcessController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {

            if(getOption('app_theme_style') == THEME_HOME_TWO){
                $workingProcess = WorkingProcess::query()->orderBy('id', 'DESC');
            }else{
                $workingProcess = WorkingProcess::query()->take(3);
            }

            if ($request->has('search_key') && !empty($request->search_key)) {
                $workingProcess->where('title', 'like', '%' . $request->search_key . '%')
                    ->orWhere('description','like','%'.$request->search_key.'%');
            }

            return datatables($workingProcess)
                ->editColumn('icon', function ($data) {
                    return '<div class="min-w-160 d-flex align-items-center cg-10">
                                <div class="flex-shrink-0 w-30 h-30 bd-one bd-c-black-stroke rounded-circle overflow-hidden bg-body-bg d-flex justify-content-center align-items-center">
                                    <img src="' . getFileUrl($data->icon) . '" alt="icon" class="rounded avatar-xs w-100 h-100 object-fit-cover">
                                </div>
                            </div>';
                })
                ->editColumn('status', function ($data) {
                    if ($data->status == STATUS_ACTIVE) {
                        return "<p class='zBadge zBadge-active'>" .  __('Active') . "</p>";
                    } else {
                        return "<p class='zBadge zBadge-inactive'>" .  __('Deactivate') . "</p>";
                    }
                })
                ->addColumn('action', function ($data) {
                    return '<ul class="d-flex align-items-center cg-5 justify-content-end">
                                <li class="align-items-center d-flex gap-2">
                                    <button onclick="getEditModal(\'' . route('admin.theme-settings.working-process.edit', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-black-stroke bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo">
                                        <img src="' . asset('assets/images/icon/edit-black.svg') . '" alt="edit" />
                                    </button>
                                </li>
                            </ul>';
                })
                ->rawColumns(['action', 'icon','status'])
                ->make(true);
        }
        $data['pageTitle'] = __('Working Process');
        $data['activeThemeSettingsIndex'] = 'active';
        $data['activeWorkingProcessIndex'] = 'active';
        return view('admin.themes.working-process.index', $data);
    }

    public function edit($id)
    {
        $data['workingProcessData'] = WorkingProcess::find($id);
        return view('admin.themes.working-process.edit', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => $request->id ? 'nullable|mimes:jpeg,png,jpg,svg,webp' : 'required|mimes:jpeg,png,jpg,svg,webp',
        ]);

        DB::beginTransaction();
        try {
            $id = $request->id;
            if ($id) {
                $workingProcess = WorkingProcess::find($id);
            } else {
                $workingProcess = new WorkingProcess();
            }

            $workingProcess->title = $request->title;
            $workingProcess->description = $request->description;
            $workingProcess->status = $request->status;

            if ($request->hasFile('icon')) {

                $newFile = new FileManager();
                $uploaded = $newFile->upload('icon', $request->icon);

                if (!is_null($uploaded)) {
                    $workingProcess->icon = $uploaded->id;
                } else {
                    return $this->error([], getMessage(SOMETHING_WENT_WRONG));
                }
            }

            $workingProcess->save();
            DB::commit();
            $message = $request->id ? __(UPDATED_SUCCESSFULLY) : __(CREATED_SUCCESSFULLY);
            return $this->success([], getMessage($message));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage($e->getMessage()));
        }
    }

    public function delete($id){

        try {
            $workingProcess = WorkingProcess::find($id);
            $workingProcess->delete();
            return $this->success([], getMessage(DELETED_SUCCESSFULLY));
        } catch (Exception $exception) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

}






