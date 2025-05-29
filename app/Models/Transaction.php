<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'house_id',
        'tenant_id',
        'status',
        'rental_period_start',
        'rental_period_end',
        'total_amount'
    ];

    protected $casts = [
        'rental_period_start' => 'datetime',
        'rental_period_end' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function rental()
    {
        return $this->belongsTo(House::class, 'house_id');
    }

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }
}
