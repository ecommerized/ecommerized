<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\DashboardService;
use App\Models\ClientInvoice;
use App\Models\ClientOrder;
use App\Models\ContactUs;
use App\Models\User;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    use ResponseTrait;

    public $dashboardService;

    public function __construct()
    {
        $this->dashboardService = new DashboardService();
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->dashboardService->recentOpenTicketHistory($request);
        }
        $data['pageTitle'] = __('Dashboard');
        $data['isDashboard'] = true;
        $data['activeDashboard'] = 'active';
        $data['totalUser'] = 0;
        $data['totalCustomer'] = 0;
        $data['totalClientCount'] = User::where('role', USER_ROLE_CLIENT)->where('status', STATUS_ACTIVE)->count();
        $data['totalTeamMemberCount'] = User::where('role', USER_ROLE_TEAM_MEMBER)->where('status', STATUS_ACTIVE)->count();
        $data['totalCompletedOrder'] = ClientOrder::where('working_status' , WORKING_STATUS_COMPLETED)->count();
        $data['totalOpenOrder'] = ClientOrder::where('working_status' , WORKING_STATUS_WORKING)->count();
        $data['totalRevenue'] = ClientInvoice::where('payment_status' , PAYMENT_STATUS_PAID)->sum('total');
        $data['yearlyRevenue'] = ClientInvoice::where('payment_status' , PAYMENT_STATUS_PAID)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total');

        return view('admin.dashboard', $data);
    }

    public function revenueOverviewChartData(Request $request)
    {
        return $this->dashboardService->revenueOverviewChartData($request);
    }

    public function clientOverviewChartData(Request $request)
    {
        return $this->dashboardService->clientOverviewChartData($request);
    }

    public function recentOpenOrder(Request $request)
    {
        return $this->dashboardService->recentOpenOrder($request);
    }
    public function contactUs(Request $request){

        if ($request->ajax()) {

            $contactUs = ContactUs::orderByDesc('id');

            if ($request->has('search_key') && !empty($request->search_key)) {
                $contactUs->where('name', 'like', '%' . $request->search_key . '%')
                    ->orWhere('email','like','%'.$request->search_key.'%');
            }
            return DataTables::of($contactUs)
                ->addIndexColumn()
               ->editColumn('action', function ($data) {
                    return '<ul class="d-flex align-items-center cg-5 justify-content-end">
                                <li class="align-items-center d-flex gap-2">
                                    <button onclick="getEditModal(\'' . route('admin.contact-us-details', $data->id) . '\', \'#contact-us-details\')"
                                            class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-black-stroke bg-white"
                                            data-bs-toggle="modal"
                                            data-bs-target="#alumniPhoneNo">
                                        <svg width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7.5 8C8.60457 8 9.5 7.10457 9.5 6C9.5 4.89543 8.60457 4 7.5 4C6.39543 4 5.5 4.89543 5.5 6C5.5 7.10457 6.39543 8 7.5 8Z" fill="#5D697A"></path>
                                            <path d="M14.9698 5.83C14.3817 4.30882 13.3608 2.99331 12.0332 2.04604C10.7056 1.09878 9.12953 0.561286 7.49979 0.5C5.87005 0.561286 4.29398 1.09878 2.96639 2.04604C1.6388 2.99331 0.617868 4.30882 0.0297873 5.83C-0.00992909 5.93985 -0.00992909 6.06015 0.0297873 6.17C0.617868 7.69118 1.6388 9.00669 2.96639 9.95396C4.29398 10.9012 5.87005 11.4387 7.49979 11.5C9.12953 11.4387 10.7056 10.9012 12.0332 9.95396C13.3608 9.00669 14.3817 7.69118 14.9698 6.17C15.0095 6.06015 15.0095 5.93985 14.9698 5.83ZM7.49979 9.25C6.857 9.25 6.22864 9.05939 5.69418 8.70228C5.15972 8.34516 4.74316 7.83758 4.49718 7.24372C4.25119 6.64986 4.18683 5.99639 4.31224 5.36596C4.43764 4.73552 4.74717 4.15642 5.20169 3.7019C5.65621 3.24738 6.23531 2.93785 6.86574 2.81245C7.49618 2.68705 8.14965 2.75141 8.74351 2.99739C9.33737 3.24338 9.84495 3.65994 10.2021 4.1944C10.5592 4.72886 10.7498 5.35721 10.7498 6C10.7485 6.86155 10.4056 7.68743 9.79642 8.29664C9.18722 8.90584 8.36133 9.24868 7.49979 9.25Z" fill="#5D697A"></path>
                                        </svg>
                                    </button>
                                </li>
                            </ul>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $data['pageTitle'] = __('Contact Us List');
        $data['activeContactUs'] = 'active';

        return view('admin.contact-us',$data);

    }

    public function contactUsDetails($id){

        $data['pageTitle'] = __('Contact Us Details');
        $data['contactUsData'] = ContactUs::find($id);
        $data['activeContactUs'] = 'active';

        return view('admin.contact-us-details',$data);
    }

}
