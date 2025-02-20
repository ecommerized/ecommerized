<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'icon',
        'banner_image',
        'description',
        'our_touch_point',
        'our_approach',
        'status',
    ];
    protected $casts = [
        'our_touch_point' => 'array',
        'our_approach' => 'array',
    ];

    public function packages(){
        return $this->belongsToMany(Package::class,'package_services');
    }
}
