<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChooseUs extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'icon',
        'title',
        'description',
        'status',
    ];
}
