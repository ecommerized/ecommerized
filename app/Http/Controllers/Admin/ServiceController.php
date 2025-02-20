<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceRequest;
use App\Models\FileManager;
use App\Models\Service;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $service = Service::query()->orderBy('id', 'DESC');

            if ($request->has('search_key') && !empty($request->search_key)) {
                $service->where('title', 'like', '%' . $request->search_key . '%');
            }

            return datatables($service)
                ->editColumn('icon', function ($data) {
                    return '<div class="min-w-160 d-flex align-items-center cg-10">
                                <div class="flex-shrink-0 w-30 h-30 bd-one bd-c-black-stroke rounded-circle overflow-hidden bg-body-bg d-flex justify-content-center align-items-center">
                                    <img src="' . getFileUrl($data->icon) . '" alt="icon" class="rounded avatar-xs w-100 h-100 object-fit-cover">
                                </div>
                            </div>';
                })
                ->editColumn('banner_image', function ($data) {
                    return '<div class="min-w-160 d-flex align-items-center cg-10">
                                <div class="flex-shrink-0 w-30 h-30 bd-one bd-c-black-stroke rounded-circle overflow-hidden bg-body-bg d-flex justify-content-center align-items-center">
                                    <img src="' . getFileUrl($data->banner_image) . '" alt="icon" class="rounded avatar-xs w-100 h-100 object-fit-cover">
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
                                    <a href="'.route('admin.services.edit', encodeId($data->id)).'" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-black-stroke bg-white">
                                        <img src="' . asset('assets/images/icon/edit-black.svg') . '" alt="edit" />
                                    </a>
                                    <button onclick="deleteItem(\'' . route('admin.services.delete', encodeId($data->id)) . '\', \'serviceDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-black-stroke bg-white" title="Delete">
                                        <img src="' . asset('assets/images/icon/delete-1.svg') . '" alt="delete">
                                    </button>
                                </li>
                            </ul>';
                })

                ->rawColumns(['action', 'icon','status','banner_image'])
                ->make(true);

        }
        $data['pageTitle'] = __('Service');
        $data['activeService'] = 'active';
        return view('admin.services.index', $data);
    }

    public function create(Request $request)
    {
        $data['pageTitle'] = __('Create');
        $data['activeService'] = 'active';
        return view('admin.services.create', $data);
    }

    public function edit($id)
    {
        $data['serviceData'] = Service::find(decodeId($id));
        $data['pageTitle'] = __('Update');
        $data['activeService'] = 'active';
        return view('admin.services.edit', $data);
    }

    public function store(ServiceRequest $request)
    {
        DB::beginTransaction();
        try {

            $id = decodeId($request->id);
            $service = $id ? Service::findOrFail($id) : new Service();

            if (Service::where('slug', getSlug($request->title))->where('id', '!=', $id)->withTrashed()->count() > 0) {
                $slug = getSlug($request->title) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->title);
            }

            $service->slug = $slug;
            $service->title = $request->title;
            $service->description = $request->description;
            $service->status = $request->status;

            if ($request->hasFile('icon')) {
                $fileManager = new FileManager();
                $uploadedIcon = $fileManager->upload('services', $request->icon);
                if (!is_null($uploadedIcon)) {
                    $service->icon = $uploadedIcon->id;
                } else {
                    DB::rollBack();
                    return $this->error([], __('Something went wrong while uploading the icon.'));
                }
            }
            if ($request->hasFile('banner_image')) {
                $fileManager = new FileManager();
                $uploadedIcon = $fileManager->upload('services', $request->banner_image);
                if (!is_null($uploadedIcon)) {
                    $service->banner_image = $uploadedIcon->id;
                } else {
                    DB::rollBack();
                    return $this->error([], __('Something went wrong while uploading the banner image.'));
                }
            }

            // Handle our touch point data, including image upload
            $ourTouchPoint = [];
            if ($request->has('our_touch_point_title')) {
                foreach ($request->input('our_touch_point_title') as $key => $title) {
                    $touchPointData = [
                        'title' => $title,
                        'details' => $request->input("our_touch_point_details.$key"),
                    ];

                    $oldPhoto = $request->input("old_our_touch_point_icon.$key");

                    if ($request->hasFile("our_touch_point_icon.$key")) {
                        $fileManager = new FileManager();
                        $uploadedImage = $fileManager->upload('our-touch-point', $request->file("our_touch_point_icon.$key"));
                        if (!is_null($uploadedImage)) {
                            $touchPointData['icon'] = $uploadedImage->id;
                        } else {
                            DB::rollBack();
                            return $this->error([], __('Something went wrong while uploading the our touch point icon.'));
                        }
                    } elseif ($oldPhoto) {
                        $touchPointData['icon'] = $oldPhoto;
                    } else {
                        $touchPointData['icon'] = null;
                    }

                    $ourTouchPoint[] = $touchPointData;
                }
            }

            $service->our_touch_point = $ourTouchPoint;

            // Handle our approach data, including image upload
            $ourApproach = [];
            if ($request->has('our_approach_title')) {
                foreach ($request->input('our_approach_title') as $key => $title) {
                    $ourApproachData = [
                        'title' => $title,
                        'details' => $request->input("our_approach_details.$key")
                    ];

                    $oldPhoto = $request->input("old_our_approach_icon.$key");

                    if ($request->hasFile("our_approach_icon.$key")) {
                        $fileManager = new FileManager();
                        $uploadedImage = $fileManager->upload('our-approach', $request->file("our_approach_icon.$key"));
                        if (!is_null($uploadedImage)) {
                            $ourApproachData['icon'] = $uploadedImage->id;
                        } else {
                            DB::rollBack();
                            return $this->error([], __('Something went wrong while uploading the our approach icon.'));
                        }
                    } elseif ($oldPhoto) {
                        $ourApproachData['icon'] = $oldPhoto;
                    } else {
                        $ourApproachData['icon'] = null;
                    }

                    $ourApproach[] = $ourApproachData;
                }
            }
            $service->our_approach = $ourApproach;

            $service->save();

            DB::commit();

            $message = $id ? __('Updated Successfully') : __('Created Successfully');
            return $this->success([], getMessage($message));

        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], __('Something went wrong! Please try again.'));
        }
    }

    public function delete($id){

        try {
            $service = Service::find(decodeId($id));
            $service->delete();
            return $this->success([], getMessage(DELETED_SUCCESSFULLY));
        } catch (Exception $exception) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

}






