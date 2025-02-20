<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AboutUs extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'banner_image',
        'details',
        'image',
        'our_goal',
        'our_vision',
        'our_mission',
        'team_member',
    ];

    protected $casts = [
        'team_member' => 'array',
        'our_goal' => 'array',
        'our_vision' => 'array',
        'our_mission' => 'array',

    ];
}
