<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientOrder extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'package_id',
        'client_id',
        'order_id',
        'amount',
        'payment_status',
        'working_status',
        'package_type',
        'start_date',
        'end_date',
        'order_create_type',
        'created_by',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

    public function plan()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }

    public function client_order_items()
    {
        return $this->hasMany(ClientOrderItem::class, 'client_order_id');
    }

    public function assignee()
    {
        return $this->hasMany(ClientOrderItemAssignee::class, 'client_order_id');
    }

    public function notes()
    {
        return $this->hasMany(ClientOrderItemNote::class, 'client_order_id');
    }
}
