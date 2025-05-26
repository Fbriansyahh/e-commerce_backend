<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'province',
        'city',
        'district',
        'postal_code',
        'street_address',
        'detail'
    ];
}
