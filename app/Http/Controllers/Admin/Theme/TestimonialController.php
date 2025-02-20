<?php

namespace App\Http\Controllers\Admin\Theme;

use App\Http\Controllers\Controller;
use App\Models\FileManager;
use App\Models\Testimonial;
use App\Models\TestimonialCategory;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestimonialController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $testimonial = Testimonial::query()->orderBy('id', 'DESC');

            if ($request->has('search_key') && !empty($request->search_key)) {
                $testimonial->where('name', 'like', '%' . $request->search_key . '%')
                         ->orWhere('designation','like','%'.$request->search_key.'%');
            }

            return datatables($testimonial)
                ->editColumn('image', function ($data) {
                    return '<div class="min-w-160 d-flex align-items-center cg-10">
                                <div class="flex-shrink-0 w-30 h-30 bd-one bd-c-black-stroke rounded-circle overflow-hidden bg-body-bg d-flex justify-content-center align-items-center">
                                    <img src="' . getFileUrl($data->image) . '" alt="image" class="rounded avatar-xs w-100 h-100 object-fit-cover">
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
                                    <button onclick="getEditModal(\'' . route('admin.theme-settings.testimonials.edit', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-black-stroke bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo">
                                        <img src="' . asset('assets/images/icon/edit-black.svg') . '" alt="edit" />
                                    </button>
                                    <button onclick="deleteItem(\'' . route('admin.theme-settings.testimonials.delete', $data->id) . '\', \'testimonialDatatable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-black-stroke bg-white" title="Delete">
                                        <img src="' . asset('assets/images/icon/delete-1.svg') . '" alt="delete">
                                    </button>
                                </li>
                            </ul>';
                })

                ->rawColumns(['action','status','image'])
                ->make(true);

        }
        $data['pageTitle'] = __('Testimonial');
        $data['activeThemeSettingsIndex'] = 'active';
        $data['activeTestimonialIndex'] = 'active';
        $data['category'] = TestimonialCategory::where('status', STATUS_ACTIVE)->get();
        return view('admin.themes.testimonial.index', $data);
    }

    public function edit($id)
    {
        $data['testimonialData'] = Testimonial::find($id);
        $data['category'] = TestimonialCategory::where('status', STATUS_ACTIVE)->get();

        return view('admin.themes.testimonial.edit', $data);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'designation' => 'required|string',
            'comment' => 'required|string',
            'image' => $request->id ? 'nullable|mimes:jpeg,png,jpg,svg,webp' : 'required|mimes:jpeg,png,jpg,svg,webp',
        ];

        if (getOption('app_theme_style') == THEME_HOME_THREE) {
            $rules['rating'] = 'required|numeric|min:1|max:5';
        }
        if (getOption('app_theme_style') == THEME_HOME_ONE) {
            $rules['category_id'] = 'required';
        }
        $validated = $request->validate($rules);


        DB::beginTransaction();
        try {
            $id = $request->id;
            if ($id) {
                $testimonial = Testimonial::find($id);
            } else {
                $testimonial = new Testimonial();
            }

            $testimonial->name = $request->name;
            $testimonial->category_id = $request->category_id;
            $testimonial->designation = $request->designation;
            $testimonial->comment = $request->comment;
            $testimonial->rating = $request->rating;
            $testimonial->status = $request->status;

            if ($request->hasFile('image')) {

                $newFile = new FileManager();
                $uploaded = $newFile->upload('testimonial', $request->image);

                if (!is_null($uploaded)) {
                    $testimonial->image = $uploaded->id;
                } else {
                    return $this->error([], getMessage(SOMETHING_WENT_WRONG));
                }
            }
            $testimonial->save();
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
            $testimonial = Testimonial::find($id);
            $testimonial->delete();
            return $this->success([], getMessage(DELETED_SUCCESSFULLY));
        } catch (Exception $exception) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

}






