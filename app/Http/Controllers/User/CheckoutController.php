<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Services\CheckoutService;
use App\Http\Services\GatewayService;
use App\Models\Bank;
use App\Models\Package;
use App\Models\Service;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;


class CheckoutController extends Controller
{
    use ResponseTrait;

    public $gatewayService, $checkoutService;

    public function __construct()
    {
        $this->gatewayService = new GatewayService;
        $this->checkoutService = new CheckoutService;
    }

    public function gatewayList(Request $request)
    {
        $gateWayService = new GatewayService;
        $data['gateways'] = $gateWayService->getActiveAll();
        if ($request->type == 'service') {
            $data['itemData'] = Service::find($request->id);
        }
        $data['banks'] = Bank::where('tenant_id', auth()->user()->tenant_id)->get();
        return view('user.checkout.partials.gateway-list', $data)->render();
    }

    public function currencyList(Request $request)
    {
        $data['currencyList'] = $this->gatewayService->getCurrencyByGatewayId($request->id);
        $data['itemAmount'] = $request->amount;
        return view('user.checkout.partials.currency-list', $data)->render();
    }

    public function checkoutModal($planId, $durationType)
    {
        $data['plan'] = Package::where('id', $planId)->first();
        $data['duration_type'] = $durationType;
        $data['gateways'] = $this->gatewayService->getActiveAll();
        $data['banks'] = Bank::all();
        if ($durationType == DURATION_MONTH) {
            $data['price'] = $data['plan']->monthly_price;
        } else {
            $data['price'] = $data['plan']->yearly_price;
        }
        return view('user.checkout.payment-modal', $data)->render();
    }

    public function checkoutOrderPlace(Request $request)
    {
        if (is_null($request->gateway)) {
            return $this->error([], __("Select gateway"));
        }

        if (is_null($request->currency)) {
            return $this->error([], __("Select Currency"));
        }

        return $this->checkoutService->userCheckoutOrder($request);
    }
}
