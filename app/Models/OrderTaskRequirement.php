<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTaskRequirement extends Model
{
    protected $fillable = [
        'order_task_id',
        'client_order_id',
        'client_order_item_id',
        'description',
        'file',
    ];

    public function orderTask()
    {
        return $this->belongsTo(OrderTask::class);
    }

    public function client_order()
    {
        return $this->belongsTo(ClientOrder::class);
    }

    public function client_order_item()
    {
        return $this->belongsTo(ClientOrderItem::class);
    }
}
