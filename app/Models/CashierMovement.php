<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashierMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'cashier_id',
        'type',
        'amount',
        'notes',
        'user_id'
    ];

    protected $casts = [
        'amount' => 'decimal:2'
    ];

    public function cashier()
    {
        return $this->belongsTo(Cashier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 