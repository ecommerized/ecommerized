<?php

namespace App\Http\Controllers\Admin\Theme;

use App\Http\Controllers\Controller;
use App\Models\FileManager;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PortfolioController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $portfolio = Portfolio::join('portfolio_categories','portfolios.category_id','=','portfolio_categories.id')
                ->select('portfolio_categories.name as portfolioCategory','portfolios.*')
                ->orderBy('portfolios.id', 'DESC');

            if ($request->has('search_key') && !empty($request->search_key)) {
                $portfolio->where('name', 'title', '%' . $request->search_key . '%');
            }

            return datatables($portfolio)
                ->addIndexColumn()
                ->editColumn('banner_image', function ($data) {
                    return '<div class="min-w-160 d-flex align-items-center cg-10">
                                <div class="flex-shrink-0 w-30 h-30 bd-one bd-c-black-stroke rounded-circle overflow-hidden bg-body-bg d-flex justify-content-center align-items-center">
                                    <img src="' . getFileUrl($data->banner_image) . '" alt="image" class="rounded avatar-xs w-100 h-100 object-fit-cover">
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
                    return
                        '<ul class="d-flex align-items-center cg-5 justify-content-end">
                            <li class="align-items-center d-flex gap-2">
                                <button onclick="openEditModal(\'' . route('admin.theme-settings.portfolios.edit', $data->id) . '\'' . ', \'#portfolio-edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-black-stroke bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo">
                                    <img src="' . asset('assets/images/icon/edit-black.svg') . '" alt="edit" />
                                </button>
                                <button onclick="deleteItem(\'' . route('admin.theme-settings.portfolios.delete', $data->id) . '\', \'portfolioDatatable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-black-stroke bg-white" title="Delete">
                                    <img src="' . asset('assets/images/icon/delete-1.svg') . '" alt="delete">
                                </button>
                            </li>
                        </ul>';
                })

                ->rawColumns(['action','status','banner_image'])
                ->make(true);

        }
        $data['pageTitle'] = __('Portfolio');
        $data['showPortfolio'] = 'show';
        $data['activePortfolio'] = 'active';
        $data['category'] = PortfolioCategory::where('status', STATUS_ACTIVE)->get();
        return view('admin.themes.portfolio.index', $data);
    }

    public function edit($id)
    {
        $data['portfolioData'] = Portfolio::find($id);
        $data['category'] = PortfolioCategory::where('status', STATUS_ACTIVE)->get();

        return view('admin.themes.portfolio.edit', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'date' => 'required|date',
            'category_id' => 'required',
            'tag' => 'required',
            'details' => 'required',
            'banner_image' => $request->id ? 'nullable|mimes:jpeg,png,jpg,svg,webp' : 'required|mimes:jpeg,png,jpg,svg,webp',
        ],[
            'category_id' => 'Category field is required',
        ]);

        DB::beginTransaction();
        try {
            $id = $request->id;
            if ($id) {
                $portfolio = Portfolio::find($id);
            } else {
                $portfolio = new Portfolio();
            }

            $portfolio->title = $request->title;
            $portfolio->client_name = $request->client_name;
            $portfolio->location = $request->location;
            $portfolio->date = $request->date;
            $portfolio->category_id = $request->category_id;
            $portfolio->tag = $request->tag;
            $portfolio->details = $request->details;
            $portfolio->status = $request->status;

            if ($request->hasFile('banner_image')) {

                $newFile = new FileManager();
                $uploaded = $newFile->upload('portfolio', $request->banner_image);

                if (!is_null($uploaded)) {
                    $portfolio->banner_image = $uploaded->id;
                } else {
                    return $this->error([], getMessage(SOMETHING_WENT_WRONG));
                }
            }
            $portfolio->save();
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
            $portfolio = Portfolio::find($id);
            $portfolio->delete();
            return $this->success([], getMessage(DELETED_SUCCESSFULLY));
        } catch (Exception $exception) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

}






