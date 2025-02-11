<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    use HasFactory;

    // Define the table name if it is not the default 'otps' (the plural of the model name)
    protected $table = 'otps';

    // Specify which attributes can be mass assigned
    protected $fillable = [
        'phone_number',
        'otp',
        'expires_at',
    ];

    // You can also add the timestamps if you are using created_at and updated_at columns
    public $timestamps = true;
}
