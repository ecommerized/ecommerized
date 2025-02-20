<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PackageRequest;
use App\Http\Services\Payment\Payment;
use App\Models\FileManager;
use App\Models\Gateway;
use App\Models\GatewayCurrency;
use App\Models\Package;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PackageController extends Controller
{
    use ResponseTrait;

    public function list(Request $request)
    {
        if ($request->ajax()) {

            $service = Package::query()->orderBy('id', 'DESC');

            if ($request->has('search_key') && !empty($request->search_key)) {
                $service->where('name', 'like', '%' . $request->search_key . '%')
                         ->orWhere('monthly_price','like','%'. $request->search_key . '%')
                         ->orWhere('yearly_price','like','%'. $request->search_key . '%');
            }

            return datatables($service)
                ->editColumn('icon', function ($data) {
                    return '<div class="min-w-160 d-flex align-items-center cg-10">
                                <div class="flex-shrink-0 w-30 h-30 bd-one bd-c-black-stroke rounded-circle overflow-hidden bg-body-bg d-flex justify-content-center align-items-center">
                                    <img src="' . getFileUrl($data->icon) . '" alt="icon" class="rounded avatar-xs w-100 h-100 object-fit-cover">
                                </div>
                            </div>';
                })
                ->editColumn('monthly_price',function ($data){
                    return showPrice($data->monthly_price);
                })
                ->editColumn('yearly_price',function ($data){
                    return showPrice($data->yearly_price);
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
                                    <a href="'.route('admin.packages.edit', encodeId($data->id)).'" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-black-stroke bg-white">
                                        <img src="' . asset('assets/images/icon/edit-black.svg') . '" alt="edit" />
                                    </a>
                                    <button onclick="deleteItem(\'' . route('admin.packages.delete', encodeId($data->id)) . '\', \'packageDatatable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-black-stroke bg-white" title="Delete">
                                        <img src="' . asset('assets/images/icon/delete-1.svg') . '" alt="delete">
                                    </button>
                                </li>
                            </ul>';
                })

                ->rawColumns(['action', 'icon','status'])
                ->make(true);

        }
        $data['pageTitle'] = 'Package';
        $data['activePackage'] = 'active';
        return view('admin.package.list', $data);
    }


    public function addNew()
    {
        $data['pageTitleParent'] = __('Package');
        $data['pageTitle'] = __('Add Package');
        $data['activePackage'] = 'active';
        $data['serviceData'] = Service::where('status',STATUS_ACTIVE)->get();
        return view('admin.package.add-new', $data);
    }

    public function edit($id)
    {
        $decodedId = decodeId($id);
        if (!$decodedId) {
            return redirect()->route('admin.packages.index')->withErrors(__('Invalid package ID.'));
        }

        $data['pageTitleParent'] = __('Package');
        $data['pageTitle'] = __('Edit Package');
        $data['activePackage'] = 'active';
        $data['package'] = Package::with('package_services')->find($decodedId);

        if (!$data['package']) {
            return redirect()->route('admin.packages.index')->withErrors(__('Package not found.'));
        }

        $data['serviceData'] = Service::where('status',STATUS_ACTIVE)->get();
        return view('admin.package.edit', $data);
    }


    public function details($id)
    {
        $data['pageTitleParent'] = __('Package');
        $data['pageTitle'] = __('Package Details');
        $data['activePackage'] = 'active';
        $data['packageDetails'] = Package::find(decodeId($id));
        return view('admin.package.details', $data);
    }


    public function store(PackageRequest $request)
    {
        DB::beginTransaction();
        try {
            // Create or Update Package
            $data = $request->id ? Package::find($request->id) : new Package();
            $data->fill($request->only(['name', 'details', 'monthly_price', 'yearly_price', 'status']));
            if(is_null($request->id)){
                $data->slug = Package::where('slug', getSlug($request->name))->exists() ?
                getSlug($request->name) . '-' . rand(100000, 999999) :
                getSlug($request->name);
            }

            // Handle Icon Upload
            if ($request->hasFile('icon')) {
                $newFile = new FileManager();
                $uploadedFile = $newFile->upload('package', $request->icon);
                $data->icon = $uploadedFile->id;
            }

            // Save the Package
            $data->save();

            // Handle Services with Quantities
            $services = $request->service_id ?? [];
            $quantities = $request->quantity ?? [];
            $quantityTypes = $request->quantity_type ?? [];
            $pivotData = [];

            foreach ($services as $index => $serviceId) {
                $pivotData[$serviceId] = [
                    'quantity' => $quantityTypes[$index] == 1 ? ($quantities[$index] ?? 0) : -1,
                ];
            }
            $data->services()->sync($pivotData);

            // Handle Extra Features
            $customFeatures = [];
            foreach ($request->other_name ?? [] as $index => $name) {
                $customFeatures[] = [
                    'name' => $name,
                    'value' => $request->other_value[$index] ?? 0,
                ];
            }
            $data->others = $customFeatures;
            $data->save();

            $gateways = RECURRING_GATEWAY;  // Add more gateways here
            foreach ($gateways as $gatewaySlug) {
                $gateway = Gateway::where(['slug' => $gatewaySlug, 'status' => ACTIVE])->first();
                $gatewayCurrency = GatewayCurrency::where(['gateway_id' => $gateway?->id])->first();
                if (!is_null($gateway) && !is_null($gatewayCurrency)) {
                    $subscriptionPrice = $data->subscriptionPrice->where('gateway_id', $gateway->id)->first();

                    $object = [
                        'webhook_url' => route('payment.subscription.webhook', ['payment_method' => $gatewaySlug]),
                        'currency' => $gatewayCurrency->currency,
                        'type' => 'plan',
                    ];

                    $paymentService = new Payment($gatewaySlug, $object);

                    // Prepare price data
                    $priceData = [
                        'monthly_price' => $data->monthly_price,
                        'yearly_price' => $data->yearly_price,
                        'monthlyPriceId' => $subscriptionPrice ? $subscriptionPrice->monthly_price_id : null,
                        'yearlyPriceId' => $subscriptionPrice ? $subscriptionPrice->yearly_price_id : null,
                        'name' => $data->name,
                    ];

                    // Save or update prices
                    $priceResponse = $paymentService->saveProductSaas($priceData);

                    if ($priceResponse['success']) {
                        // Save subscription price details in the database for the gateway
                        $data->subscriptionPrice()->updateOrCreate(
                            ['gateway_id' => $gateway->id],
                            [
                                'gateway' => $gatewaySlug,
                                'gateway_currency_id' => $gatewayCurrency->id,
                                'monthly_price_id' => $priceResponse['data']['monthly_price_id'],
                                'yearly_price_id' => $priceResponse['data']['yearly_price_id'],
                            ]
                        );
                    } else {
                        return $this->error([], __('Error saving product for ' . ucfirst($gatewaySlug)));
                    }
                }
            }

            DB::commit();
            return $this->success([], getMessage($request->id ? UPDATED_SUCCESSFULLY : CREATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], SOMETHING_WENT_WRONG);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $packageData = Package::where('id',decodeId($id))->first();
            $packageData->delete();


            DB::commit();
            return $this->success([], getMessage(DELETED_SUCCESSFULLY));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error([], getErrorMessage($e, $e->getMessage()));
        }
    }
}
