<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public const STATUS = 'status';
    public const CUSTOMER_ID = 'customer_id';
    public const AMOUNT = 'amount';

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        self::STATUS,
        self::AMOUNT,
        self::CUSTOMER_ID
    ];
}
