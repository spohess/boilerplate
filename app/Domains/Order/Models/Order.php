<?php

declare(strict_types=1);

namespace App\Domains\Order\Models;

use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected static function newFactory(): OrderFactory
    {
        return OrderFactory::new();
    }

    protected $fillable = [
        'customer_name',
        'customer_email',
        'product',
        'quantity',
        'total_price',
        'status',
        'amount',
    ];
}
