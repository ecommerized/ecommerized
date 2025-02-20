<?php

namespace App\Http\Services;

use App\Models\Bank;
use App\Models\Gateway;
use App\Models\GatewayCurrency;
use App\Models\User;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class GatewayService
{
    use ResponseTrait;

    public function getAll($tenant_id = null)
    {
        return Gateway::all();
    }

    public function getActiveAll()
    {
        return Gateway::where('status', ACTIVE)->get();
    }

    public function getInfo($id)
    {
        return Gateway::findOrFail(decrypt($id));
    }

    public function getCurrenciesByGatewayId($id)
    {
        $data['gateway'] = $this->getInfo($id);
        if ($data['gateway']->slug == 'bank') {
            $data['banks'] = $this->banks();
        }
        $data['image'] = $data['gateway']->icon;
        $currencies = GatewayCurrency::where('gateway_id', decrypt($id))->get();
        foreach ($currencies as $currency) {
            $currency->symbol;
        }
        $data['currencies'] = $currencies;
        return $this->success($data);
    }

    public function banks($tenant_id = null)
    {
        return Bank::all();
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $gateway = Gateway::findOrFail(decrypt($request->id));
            if ($gateway->slug == 'bank') {
                $bankIds = [];
                for ($i = 0; $i < count($request->bank['name']); $i++) {
                    $bank = Bank::updateOrCreate([
                        'id' => isset($request->bank['id'][$i]) ? $request->bank['id'][$i] : null,
                    ], [
                        'gateway_id' => $gateway->id,
                        'name' => $request->bank['name'][$i],
                        'details' => $request->bank['details'][$i],
                        'status' => ACTIVE,
                    ]);
                    array_push($bankIds, $bank->id);
                }
                Bank::whereNotIn('id', $bankIds)->delete();
            } else {
                $gateway->mode = $request->mode == GATEWAY_MODE_LIVE ? GATEWAY_MODE_LIVE : GATEWAY_MODE_SANDBOX;
                $gateway->url = $request->url;
                $gateway->key = $request->key;
                $gateway->secret = $request->secret;
            }
            $gateway->status = $request->status == STATUS_ACTIVE ? STATUS_ACTIVE : STATUS_PENDING;
            $gateway->save();

            $gatewayCurrencyIds = [];
            if (is_array($request->currency)) {
                foreach ($request->currency as $key => $currency) {
                    $gatewayCurrency =   GatewayCurrency::updateOrCreate([
                        'id' => isset($request->currency_id[$key]) ? $request->currency_id[$key] : null
                    ], [
                        'gateway_id' => $gateway->id,
                        'currency' => $currency,
                        'conversion_rate' => $request->conversion_rate[$key],
                    ]);
                    array_push($gatewayCurrencyIds, $gatewayCurrency->id);
                }
            } else {
                throw new Exception(__('Please add at least one currency'));
            }
            GatewayCurrency::whereNotIn('id', $gatewayCurrencyIds)->where('gateway_id', $gateway->id)->delete();

            DB::commit();
            $message = $request->id ? __(UPDATED_SUCCESSFULLY) : __(CREATED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([],  $message);
        }
    }

    public function getCurrencyByGatewayId($id)
    {
        return GatewayCurrency::where('gateway_id', $id)->get();
    }
}
