<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HouseImage extends Model
{
    protected $fillable = [
        'house_id',
        'image_url',
        'image_order',
        'is_front_image'
    ];

    protected $casts = [
        'is_front_image' => 'boolean'
    ];

    public function house()
    {
        return $this->belongsTo(House::class);
    }
}
