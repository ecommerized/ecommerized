<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Portfolio extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'tag',
        'title',
        'details',
        'client_name',
        'banner_image',
        'location',
        'date',
        'status',
    ];

   protected $casts = [
     'tag' => 'array'
   ];
}
