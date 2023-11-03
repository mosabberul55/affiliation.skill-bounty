<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_phone',
        'customer_name',
        'sale_price',
        'percent',
        'income',
        'code'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'customer_phone' => 'string',
        'customer_name' => 'string',
        'sale_price' => 'decimal:2',
        'percent' => 'float',
        'income' => 'decimal:2',
        'code' => 'string'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function top10Affiliates()
    {
        return self::selectRaw('user_id, SUM(income) as total_income')
            ->groupBy('user_id')
            ->orderByRaw('SUM(income) DESC')
            ->limit(10)
            ->with('user')
            ->get();
    }
}
