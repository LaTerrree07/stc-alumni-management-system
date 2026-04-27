<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $primaryKey = 'donation_id';

    protected $fillable = [
        'user_id',
        'donor_name',
        'amount',
        'donation_date',
        'payment_type',
        'payment_method',
        'reference_details',
        'proof_of_payment',
        'purpose',
        'status',
        'verified_by',
        'verified_at',
        'admin_note',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'donation_date' => 'date',
            'verified_at' => 'datetime',
        ];
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by', 'user_id');
    }
}