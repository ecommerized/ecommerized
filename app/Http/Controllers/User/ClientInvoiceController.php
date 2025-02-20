<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Services\ClientInvoiceServices;
use App\Http\Services\GatewayService;
use App\Models\ClientInvoice;
use App\Models\ClientOrder;
use App\Models\ClientOrderItem;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ClientInvoiceController extends Controller
{
    use ResponseTrait;

    public $clientInvoiceService, $gatewayService;

    public function __construct()
    {
        $this->clientInvoiceService = new ClientInvoiceServices();
        $this->gatewayService = new GatewayService;
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            return $this->clientInvoiceService->getClientInvoiceListData($request);
        }
        $data['pageTitle'] = __('Invoice list');
        $data['activeClientInvoiceIndex'] = 'active';
        $data['invoiceCount'] = $this->clientInvoiceService->invoiceCount();
        $data['gateways'] = $this->gatewayService->getAll(auth()->user()->tenant_id);
        $data['banks'] = $this->gatewayService->banks(auth()->user()->tenant_id);
        return view('user.client-invoice.list', $data);
    }

    public function details($id)
    {
        $data['clientInvoice'] = ClientInvoice::with(['client', 'gateway'])->with(['order.plan'])->find($id);
        $data['clientInvoiceOrder'] = $data['clientInvoice']->order;
        return view('user.client-invoice.invoice-details', $data);
    }

    public function invoicePrint($id)
    {
        $data['title'] = __('Invoice Print');
        $data['clientInvoice'] = ClientInvoice::with(['client', 'gateway'])->with(['order.plan'])->find($id);
        $data['clientInvoiceOrder'] = $data['clientInvoice']->order;
        return view('user.client-invoice.print-invoice', $data);
    }
}
