<?php

namespace App\Http\Controllers\Admin\Theme;

use App\Http\Controllers\Controller;
use App\Models\TestimonialCategory;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestimonialCategoryController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $testimonialCategory = TestimonialCategory::query()->orderBy('id', 'DESC');

            if ($request->has('search_key') && !empty($request->search_key)) {
                $testimonialCategory->where('name', 'like', '%' . $request->search_key . '%');
            }

            return datatables($testimonialCategory)
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
                                    <button onclick="getEditModal(\'' . route('admin.theme-settings.testimonials.categories.edit', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-black-stroke bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo">
                                        <img src="' . asset('assets/images/icon/edit-black.svg') . '" alt="edit" />
                                    </button>
                                    <button onclick="deleteItem(\'' . route('admin.theme-settings.testimonials.categories.delete', $data->id) . '\', \'testimonialCategoryDatatable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-black-stroke bg-white" title="Delete">
                                        <img src="' . asset('assets/images/icon/delete-1.svg') . '" alt="delete">
                                    </button>
                                </li>
                            </ul>';
                })

                ->rawColumns(['action','status'])
                ->make(true);

        }
        $data['pageTitle'] = __('Testimonial Category');
        $data['activeThemeSettingsIndex'] = 'active';
        $data['activeTestimonialCategory'] = 'active';
        return view('admin.themes.testimonial.categories.index', $data);
    }

    public function edit($id)
    {
        $data['testimonialCategoryData'] = TestimonialCategory::find($id);
        return view('admin.themes.testimonial.categories.edit', $data);
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
                $testimonialCategory = TestimonialCategory::find($id);
            } else {
                $testimonialCategory = new TestimonialCategory();
            }

            $testimonialCategory->name = $request->name;
            $testimonialCategory->status = $request->status;

            $testimonialCategory->save();
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
            $testimonialCategory = TestimonialCategory::find($id);
            $testimonialCategory->delete();
            return $this->success([], getMessage(DELETED_SUCCESSFULLY));
        } catch (Exception $exception) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

}






