<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageService extends Model
{
    protected $fillable = [
        'package_id',
        'service_id',
        'quantity',
    ];

}
