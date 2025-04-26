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
        'decription',
        'price',
        'number_of_rooms',
        'home_type',
        'status',
    ];
    public function landlord()
    {
        return $this->belongsTo(User::class, 'landlord_id');
    }
}
