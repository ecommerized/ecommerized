<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    use ResponseTrait;

    public function list(Request $request)
    {
        $data['pageTitle'] = __('Plan');
        $data['activePlan'] = 'active';
        $data['pageType'] = 0;
        if ($request->type != null) {
            $data['pageType'] = $request->type;
        }
        $data['planList'] = Package::where('status', STATUS_ACTIVE)->get();

        return view('user.plans.list', $data);
    }
}
