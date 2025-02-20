<?php

namespace App\Http\Controllers\Admin\Theme;

use App\Http\Controllers\Controller;
use App\Models\FileManager;
use App\Models\MembershipBenefits;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MembershipBenefitsController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $membershipBenefits = MembershipBenefits::query()->orderBy('id', 'DESC');

            if ($request->has('search_key') && !empty($request->search_key)) {
                $membershipBenefits->where('title', 'like', '%' . $request->search_key . '%')
                    ->orWhere('description','like','%'.$request->search_key.'%');
            }

            return datatables($membershipBenefits)
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
                                    <button onclick="getEditModal(\'' . route('admin.theme-settings.membership-benefits.edit', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-black-stroke bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo">
                                        <img src="' . asset('assets/images/icon/edit-black.svg') . '" alt="edit" />
                                    </button>
                                    <button onclick="deleteItem(\'' . route('admin.theme-settings.membership-benefits.delete', $data->id) . '\', \'membershipBenefitsDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-black-stroke bg-white" title="Delete">
                                        <img src="' . asset('assets/images/icon/delete-1.svg') . '" alt="delete">
                                    </button>
                                </li>
                            </ul>';
                })
                ->rawColumns(['action', 'icon','status'])
                ->make(true);
        }
        $data['pageTitle'] = __('Membership Benefits');
        $data['activeThemeSettingsIndex'] = 'active';
        $data['activeMembershipBenefitsIndex'] = 'active';
        return view('admin.themes.membership-benefits.index', $data);
    }

    public function edit($id)
    {
        $data['membershipBenefitsData'] = MembershipBenefits::find($id);
        return view('admin.themes.membership-benefits.edit', $data);
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
                $membershipBenefits = MembershipBenefits::find($id);
            } else {
                $membershipBenefits = new MembershipBenefits();
            }

            $membershipBenefits->title = $request->title;
            $membershipBenefits->description = $request->description;
            $membershipBenefits->status = $request->status;

            if ($request->hasFile('icon')) {

                $newFile = new FileManager();
                $uploaded = $newFile->upload('icon', $request->icon);

                if (!is_null($uploaded)) {
                    $membershipBenefits->icon = $uploaded->id;
                } else {
                    return $this->error([], getMessage(SOMETHING_WENT_WRONG));
                }
            }

            $membershipBenefits->save();
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
            $membershipBenefits = MembershipBenefits::find($id);
            $membershipBenefits->delete();
            return $this->success([], getMessage(DELETED_SUCCESSFULLY));
        } catch (Exception $exception) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

}






