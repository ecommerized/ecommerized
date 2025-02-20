<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientOrderItemAssignee extends Model
{
    use SoftDeletes;

    protected  $fillable = [
        'client_order_id',
        'client_order_item_id',
        'assigned_to',
        'assigned_by',
        'is_active',
    ];
}
