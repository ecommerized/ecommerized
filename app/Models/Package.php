<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'details',
        'number_of_client',
        'number_of_order',
        'others',
        'monthly_price',
        'yearly_price',
        'status',
        'is_default',
        'is_trail',
    ];
    protected $casts = [
        'others' => 'array'
    ];

    public function package_services(){
        return $this->hasMany(PackageService::class, 'package_id');
    }

    public function services(){
        return $this->belongsToMany(Service::class,'package_services');
    }

    public function subscriptionPrice()
    {
        return $this->hasMany(PackageGatewayPrice::class, 'package_id', 'id');
    }
}
