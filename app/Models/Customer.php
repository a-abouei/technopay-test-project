<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public const NATIONAL_CODE = 'national_code';
    public const MOBILE_NUMBER = 'mobile_number';
    public const FIRST_NAME = 'first_name';
    public const LAST_NAME = 'last_name';

    /**
     * @var string[]
     */
    protected $fillable = [
        self::NATIONAL_CODE,
        self::MOBILE_NUMBER,
        self::FIRST_NAME,
        self::LAST_NAME
    ];

}
