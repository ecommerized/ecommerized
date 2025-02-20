<?php

namespace App\Http\Controllers\Admin\Theme;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\FileManager;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $blog = Blog::leftJoin('blog_categories','blogs.blog_category_id','=','blog_categories.id')->select('blog_categories.name as blog_category','blogs.*')->orderBy('blogs.id', 'DESC');

            if ($request->has('search_key') && !empty($request->search_key)) {
                $blog->where('blogs.title', 'like', '%' . $request->search_key . '%');
            }

            return datatables($blog)
                ->addIndexColumn()
                ->editColumn('banner_image', function ($data) {
                    return '<div class="min-w-160 d-flex align-items-center cg-10">
                                <div class="flex-shrink-0 w-30 h-30 bd-one bd-c-black-stroke rounded-circle overflow-hidden bg-body-bg d-flex justify-content-center align-items-center">
                                    <img src="' . getFileUrl($data->banner_image) . '" alt="banner_image" class="rounded avatar-xs w-100 h-100 object-fit-cover">
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
                                    <button onclick="getEditModal(\'' . route('admin.blogs.edit', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-black-stroke bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo">
                                        <img src="' . asset('assets/images/icon/edit-black.svg') . '" alt="edit" />
                                    </button>
                                    <button onclick="deleteItem(\'' . route('admin.blogs.delete', $data->id) . '\', \'blogDatatable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-black-stroke bg-white" title="Delete">
                                        <img src="' . asset('assets/images/icon/delete-1.svg') . '" alt="delete">
                                    </button>
                                </li>
                            </ul>';
                })
                ->rawColumns(['action', 'banner_image','status'])
                ->make(true);
        }
        $data['pageTitle'] = __('Manage Blog');
        $data['activeBlogIndex'] = 'active';
        $data['showManageBlog'] = 'show';
        $data['category'] = BlogCategory::where('status' , STATUS_ACTIVE)->get();

        return view('admin.themes.blog.index', $data);
    }

    public function edit($id)
    {
        $data['blogData'] = Blog::find($id);
        $data['category'] = BlogCategory::all();

        return view('admin.themes.blog.edit', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'details' => 'required',
            'publish_date' => 'required',
            'blog_category_id' => 'required',
            'banner_image' => $request->id ? 'nullable|mimes:jpeg,png,jpg,svg,webp|max:1024' : 'required|mimes:jpeg,png,jpg,svg,webp|max:1024',
        ]);
        DB::beginTransaction();
        try {
            $id = $request->id;
            if ($id) {
                $blogs = Blog::find($id);
            } else {
                $blogs = new Blog();
            }
            if (Blog::where('slug', getSlug($request->title))->where('id', '!=', $id)->withTrashed()->count() > 0) {
                $slug = getSlug($request->title) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->title);
            }

            $blogs->slug = $slug;
            $blogs->title = $request->title;
            $blogs->details = $request->details;
            $blogs->meta_title = $request->meta_title;
            $blogs->meta_keyword = $request->meta_keyword;
            $blogs->publish_date = $request->publish_date;
            $blogs->meta_description = $request->meta_description;
            $blogs->blog_category_id = $request->blog_category_id;
            $blogs->created_by = Auth::user()->id;
            $blogs->status = $request->status;

            if ($request->hasFile('banner_image')) {

                $newFile = new FileManager();
                $uploadedFile = $newFile->upload('blog', $request->banner_image);

                $blogs->banner_image = $uploadedFile->id;
            }
            if ($request->hasFile('og_image')) {

                $newFile = new FileManager();
                $uploadedFile = $newFile->upload('blog', $request->og_image);

                $blogs->og_image = $uploadedFile->id;
            }
            $blogs->save();
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
            $blog = Blog::find($id);
            $blog->delete();
            return $this->success([], getMessage(DELETED_SUCCESSFULLY));
        } catch (Exception $exception) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

}






