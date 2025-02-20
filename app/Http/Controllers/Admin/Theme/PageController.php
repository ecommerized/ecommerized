<?php

namespace App\Http\Controllers\Admin\Theme;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\FileManager;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $pages = Page::query()->orderBy('id', 'DESC');

            if ($request->has('search_key') && !empty($request->search_key)) {
                $pages->where('title', 'like', '%' . $request->search_key . '%');
            }

            return datatables($pages)
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
                                    <button onclick="getEditModal(\'' . route('admin.theme-settings.pages.edit', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-black-stroke bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo">
                                        <img src="' . asset('assets/images/icon/edit-black.svg') . '" alt="edit" />
                                    </button>
                                    <button onclick="deleteItem(\'' . route('admin.theme-settings.pages.delete', $data->id) . '\', \'pageDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-black-stroke bg-white" title="Delete">
                                        <img src="' . asset('assets/images/icon/delete-1.svg') . '" alt="delete">
                                    </button>
                                </li>
                            </ul>';
                })

                ->rawColumns(['action','status'])
                ->make(true);

        }
        $data['pageTitle'] = __('Pages');
        $data['activeThemeSettingsIndex'] = 'active';
        $data['activePageSection'] = 'active';
        return view('admin.themes.page.index', $data);
    }

    public function edit($id)
    {
        $data['pageData'] = Page::find($id);
        return view('admin.themes.page.edit', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $id = $request->id;
            if ($id) {
                $pages = Page::find($id);
            } else {
                $pages = new Page();
            }
            if (Page::where('slug', getSlug($request->title))->where('id', '!=', $id)->withTrashed()->count() > 0) {
                $slug = getSlug($request->title) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->title);
            }
            $pages->slug = $slug;
            $pages->title = $request->title;
            $pages->description = $request->description;
            $pages->status = $request->status;

            $pages->save();
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
            $pages = Page::find($id);
            $pages->delete();
            return $this->success([], getMessage(DELETED_SUCCESSFULLY));
        } catch (Exception $exception) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

}






