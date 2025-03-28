<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Doctor;

class PayherePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'patient_name',
        'contact_no',
        'doctor_id',
        'schedule',
        'amount',
        'status',
    ];

    // Optional: link to doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
