<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cashier extends Model
{
    use HasFactory;

    protected $fillable = [
        'opening_date',
        'closing_date',
        'opening_amount',
        'closing_amount',
        'current_amount',
        'difference_amount',
        'status',
        'opening_notes',
        'closing_notes',
        'user_id'
    ];

    protected $casts = [
        'opening_date' => 'datetime',
        'closing_date' => 'datetime',
        'opening_amount' => 'decimal:2',
        'closing_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'difference_amount' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movements()
    {
        return $this->hasMany(CashierMovement::class);
    }
} 