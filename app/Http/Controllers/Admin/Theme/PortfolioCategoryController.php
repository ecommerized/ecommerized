<?php

namespace App\Http\Controllers\Admin\Theme;

use App\Http\Controllers\Controller;
use App\Models\PortfolioCategory;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PortfolioCategoryController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $portfolioCategory = PortfolioCategory::query()->orderBy('id', 'DESC');

            if ($request->has('search_key') && !empty($request->search_key)) {
                $portfolioCategory->where('name', 'like', '%' . $request->search_key . '%');
            }

            return datatables($portfolioCategory)
                ->addIndexColumn()
                ->editColumn('status', function ($data) {
                    if ($data->status == STATUS_ACTIVE) {
                        return "<p class='zBadge zBadge-active'>" .  __('Active') . "</p>";
                    } else {
                        return "<p class='zBadge zBadge-inactive'>" .  __('Deactivate') . "</p>";
                    }
                })
                ->addColumn('action', function ($data) {
                    return
                        '<ul class="d-flex align-items-center cg-5 justify-content-end">
                            <li class="align-items-center d-flex gap-2">
                                <button onclick="getEditModal(\'' . route('admin.theme-settings.portfolios.categories.edit', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-black-stroke bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo">
                                    <img src="' . asset('assets/images/icon/edit-black.svg') . '" alt="edit" />
                                </button>
                                <button onclick="deleteItem(\'' . route('admin.theme-settings.portfolios.categories.delete', $data->id) . '\', \'portfolioCategoryDatatable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-black-stroke bg-white" title="Delete">
                                    <img src="' . asset('assets/images/icon/delete-1.svg') . '" alt="delete">
                                </button>
                            </li>
                        </ul>';
                })
                ->rawColumns(['action','status'])
                ->make(true);

        }
        $data['pageTitle'] = __('Portfolio Category');
        $data['showPortfolio'] = 'show';
        $data['activePortfolioCategory'] = 'active';
        return view('admin.themes.portfolio.categories.index', $data);
    }

    public function edit($id)
    {
        $data['portfolioCategoryData'] = PortfolioCategory::find($id);
        return view('admin.themes.portfolio.categories.edit', $data);
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
                $portfolioCategory = PortfolioCategory::find($id);
            } else {
                $portfolioCategory = new PortfolioCategory();
            }

            $portfolioCategory->name = $request->name;
            $portfolioCategory->status = $request->status;

            $portfolioCategory->save();
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
            $portfolioCategory = PortfolioCategory::find($id);
            $portfolioCategory->delete();
            return $this->success([], getMessage(DELETED_SUCCESSFULLY));
        } catch (Exception $exception) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

}






