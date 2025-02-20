<?php

namespace App\Http\Controllers\Admin\Theme;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogCategoryController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $blogCategory = BlogCategory::query()->orderBy('id', 'DESC');

            if ($request->has('search_key') && !empty($request->search_key)) {
                $blogCategory->where('name', 'like', '%' . $request->search_key . '%');
            }

            return datatables($blogCategory)
               ->addIndexColumn()
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
                                    <button onclick="getEditModal(\'' . route('admin.blogs.categories.edit', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-black-stroke bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo">
                                        <img src="' . asset('assets/images/icon/edit-black.svg') . '" alt="edit" />
                                    </button>
                                    <button onclick="deleteItem(\'' . route('admin.blogs.categories.delete', $data->id) . '\', \'blogCategoryDatatable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-black-stroke bg-white" title="Delete">
                                        <img src="' . asset('assets/images/icon/delete-1.svg') . '" alt="delete">
                                    </button>
                                </li>
                            </ul>';
                })
                ->rawColumns(['action', 'icon','status'])
                ->make(true);
        }
        $data['pageTitle'] = __('Blog Category');
        $data['activeBlogCategoryIndex'] = 'active';
        $data['showManageBlog'] = 'show';
        return view('admin.themes.blog.categories.index', $data);
    }

    public function edit($id)
    {
        $data['blogCategoryData'] = BlogCategory::find($id);
        return view('admin.themes.blog.categories.edit', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $id = $request->id;
            if ($id) {
                $blogCategory = BlogCategory::find($id);
            } else {
                $blogCategory = new BlogCategory();
            }

            if (BlogCategory::where('slug', getSlug($request->name))->where('id', '!=', $id)->withTrashed()->count() > 0) {
                $slug = getSlug($request->name) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->name);
            }

            $blogCategory->name = $request->name;
            $blogCategory->slug = $slug;
            $blogCategory->status = $request->status;

            $blogCategory->save();
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
            $blogCategory = BlogCategory::find($id);
            $blogCategory->delete();
            return $this->success([], getMessage(DELETED_SUCCESSFULLY));
        } catch (Exception $exception) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

}






