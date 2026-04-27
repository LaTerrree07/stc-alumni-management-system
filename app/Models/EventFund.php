<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventFund extends Model
{
    protected $primaryKey = 'fund_id';

    protected $fillable = [
        'fund_year',
        'total_fund',
        'used_fund',
        'remaining_fund',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'total_fund' => 'decimal:2',
            'used_fund' => 'decimal:2',
            'remaining_fund' => 'decimal:2',
        ];
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }
}