<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_no',
        'appointment_status',
        'patient_id',
        'patient_name',
        'contact_no',
        'doctor_id',
        'appointment_date_time',
        'payment_status',
        'payment_id',
        'attendance_status', // Updated from present_status
        'username'
    ];

    // Relationship: Each appointment belongs to a patient
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    // Relationship: Each appointment belongs to a doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'Doc_id'); // Ensure correct mapping
    }

    // Relationship: Each appointment may have a payment
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    // **Accessor for Doctor Name**
    public function getDoctorNameAttribute()
    {
        return $this->doctor ? $this->doctor->name : 'Unknown Doctor';
    }
}
