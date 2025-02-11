<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'amount',
        'payment_method',
        'payment_date',
        'status'
    ];

    // Relationship: A Payment belongs to an Appointment
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    // Relationship: A Payment has one Bill
    public function bill()
    {
        return $this->hasOne(Bill::class);
    }
}
