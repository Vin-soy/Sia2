<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;
    protected $fillable = [
        'landlord_id',
        'address',
        'description',
        'price',
        'number_of_rooms',
        'house_type',
        'status',
    ];
    public function landlord()
    {
        return $this->belongsTo(User::class, 'landlord_id');
    }

    public function images()
    {
        return $this->hasMany(HouseImage::class)->orderBy('image_order');
    }

    public function applications()
    {
        return $this->hasMany(Transaction::class, 'house_id');
    }
}
