<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ClientInvoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_order_id',
        'client_id',
        'invoice_id',
        'total',
        'is_mailed',
        'payment_status',
        'create_type',
        'transaction_id',
        'payment_id',
        'gateway_id',
        'conversion_rate',
        'system_currency',
        'gateway_currency',
        'bank_id',
        'bank_deposit_by',
        'bank_deposit_slip_id',
        'transaction_amount',
    ];

    public function client(){
        return $this->belongsTo(User::class,'client_id', 'id');
    }

    public function clientOrderItems(){
        return $this->hasMany(ClientOrderItem::class, 'client_order_id', 'client_order_id');
    }

    public function gateway()
    {
        return $this->belongsTo(Gateway::class, 'gateway_id', 'id');
    }
    public function order()
    {
        return $this->belongsTo(ClientOrder::class, 'client_order_id', 'id');
    }

}
