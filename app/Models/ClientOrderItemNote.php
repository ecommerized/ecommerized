<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientOrderItemNote extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_order_id',
        'client_order_item_id',
        'details',
        'user_id',
    ];
}
