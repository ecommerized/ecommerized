<?php

namespace App\Http\Services;

use App\Models\Currency;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class CurrencyService
{
    use ResponseTrait;

    public function getAllData()
    {
        $currencies = Currency::orderBy('id', 'desc')
        ->select('id', 'currency_code', 'current_currency', 'symbol', 'currency_placement');
        return datatables($currencies)
            ->addIndexColumn()
            ->editColumn('currency_code', function ($data) {
                $currencyCode = $data->currency_code;
                if ($data->current_currency == STATUS_ACTIVE) {
                    $currencyCode = $currencyCode . ' <b>(Current Currency)';
                }
                return $currencyCode;
            })
            ->addColumn('action', function ($data) {
                if((auth()->user()->role == USER_ROLE_ADMIN) || (auth()->user()->role == USER_ROLE_TEAM_MEMBER)){
                    $role = 'admin';
                }else{
                    $role = 'super-admin';
                }
                return '<ul class="d-flex align-items-center cg-5 justify-content-end">
                <li class="align-items-center d-flex gap-2">
                    <button onclick="getEditModal(\'' . route($role.'.setting.currencies.edit', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-black-stroke bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo">
                        <img src="' . asset('assets/images/icon/edit-black.svg') . '" alt="edit" />
                    </button>
                    <button onclick="deleteItem(\'' . route($role.'.setting.currencies.delete', $data->id) . '\', \'commonDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-black-stroke bg-white" title="Delete">
                        <img src="' . asset('assets/images/icon/delete-1.svg') . '" alt="delete">
                    </button>
                </li>
            </ul>';
            })
            ->rawColumns(['action', 'currency_code'])
            ->make(true);
    }


    public function store($request)
    {
        DB::beginTransaction();
        try {
            $currency = new Currency();
            $currency->currency_code = $request->currency_code;
            $currency->symbol = $request->symbol;
            $currency->currency_placement = $request->currency_placement;
            $currency->save();

            if ($request->current_currency) {
                Currency::where('id', $currency->id)->update(['current_currency' => STATUS_ACTIVE]);
                Currency::where('id', '!=', $currency->id)->update(['current_currency' => STATUS_PENDING]);
            }

            DB::commit();

            $message = getMessage(CREATED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $currency = Currency::findOrFail($id);
            $currency->currency_code = $request->currency_code;
            $currency->symbol = $request->symbol;
            $currency->currency_placement = $request->currency_placement;
            $currency->save();
            if ($request->current_currency) {
                Currency::where('id', $currency->id)->update(['current_currency' => STATUS_ACTIVE]);
                Currency::where('id', '!=', $currency->id)->update(['current_currency' => STATUS_PENDING]);
            }

            DB::commit();

            $message = getMessage(UPDATED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function getById($id)
    {
        return Currency::findOrFail($id);
    }

    public function deleteById($id)
    {
        try {
            DB::beginTransaction();
            $currency = Currency::findOrFail($id);
            $currency->delete();
            DB::commit();
            $message = getMessage(DELETED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }
}
