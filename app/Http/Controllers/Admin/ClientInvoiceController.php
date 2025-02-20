<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\ClientInvoiceServices;
use App\Models\ClientInvoice;
use App\Models\ClientOrderItem;
use App\Models\Gateway;
use App\Models\Package;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ClientInvoiceController extends Controller
{
    use ResponseTrait;

    public $clientInvoiceService;

    public function __construct()
    {
        $this->clientInvoiceService = new ClientInvoiceServices();
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            return $this->clientInvoiceService->getClientInvoiceListData($request);
        }
        $data['pageTitle'] = __('Client Invoice list');
        $data['activeClientInvoiceIndex'] = 'active';
        $data['gateways'] = Gateway::where('status', STATUS_ACTIVE)->with('currencies')->get();
        $data['invoiceCount'] = $this->clientInvoiceService->invoiceCount();
        return view('admin.client-invoice.list', $data);
    }

    public function details($id)
    {
        $data['clientInvoice'] = ClientInvoice::with(['client', 'gateway'])->with(['order.plan'])->find($id);
        $data['clientInvoiceOrder'] = $data['clientInvoice']->order;
        return view('admin.client-invoice.invoice-details', $data);
    }

    public function paymentEdit($id)
    {
        $data['clientInvoice'] = ClientInvoice::with('client')->find($id);
        $data['allPackage'] = Package::where('status', STATUS_ACTIVE)->get();
        $data['gateways'] = Gateway::where('status', STATUS_ACTIVE)->with('currencies')->get();
        return view('admin.client-invoice.payment_edit', $data);
    }

    public function getService()
    {
        $data = $this->clientInvoiceService->getService();
        return $this->success($data);
    }

    public function getOrder(Request $request)
    {
        $data['orders'] = $this->clientInvoiceService->getOrder($request->id);
        return view('admin.client-invoice.list_for_dropdown', $data);
    }

    public function invoicePrint($id)
    {
        $data['title'] = __('Invoice Print');
        $data['clientInvoice'] = ClientInvoice::with(['client', 'gateway'])->with(['order.plan'])->find($id);
        $data['clientInvoiceOrder'] = $data['clientInvoice']->order;
        return view('admin.client-invoice.print-invoice', $data);
    }

    public function edit($id){
        $data['pageTitleParent'] = __('Invoice');
        $data['pageTitle'] = __('Edit Invoice');
        $data['activeClientInvoiceIndex'] = 'active';

        $data['clientInvoice'] = ClientInvoice::find($id);
        $data['invoiceItem'] = ClientOrderItem::where('order_id', $data['clientInvoice']->order_id)->get();
        $data['service'] = $this->clientInvoiceService->getService();
        $data['allClient'] = User::where('role', USER_ROLE_CLIENT)->get();
        $data['orders'] = $this->clientInvoiceService->getOrder($data['clientInvoice']->client_id);

        return view('admin.client-invoice.edit-invoice', $data);
    }

    public function paymentStatusChange(Request $request, $id)
    {
        return $this->clientInvoiceService->paymentStatusChange($request, $id);
    }

}

