<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'tenant_id',
        'house_id',
        'rental_period_start',
        'rental_period_end',
        'total_amount',
        'status',
    ];
}
