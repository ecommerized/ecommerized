<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ClientOrderItem extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'client_order_id',
        'service_id',
        'quantity',
        'status',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function order()
    {
        return $this->belongsTo(ClientOrder::class, 'client_order_id');
    }

    public function clientInvoice(){
        return $this->belongsTo(ClientInvoice::class, 'client_order_id', 'client_order_id');
    }

    public function assignee()
    {
        return $this->hasMany(ClientOrderItemAssignee::class, 'client_order_item_id');
    }

    public function notes()
    {
        return $this->hasMany(ClientOrderItemNote::class, 'client_order_item_id');
    }
}
