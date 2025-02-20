<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'image',
        'designation',
        'comment',
        'status',
        'rating',
        'category_id',
    ];

    public function category(){
        return $this->hasOne(TestimonialCategory::class);
    }
}
