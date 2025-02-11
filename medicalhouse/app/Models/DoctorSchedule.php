<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    use HasFactory;

    protected $table = 'doctor_schedules';

    protected $primaryKey = null; // Fix composite key issue
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false; // Disable timestamps

    protected $fillable = [
        'Doc_id',
        'date',
        'start_time',
        'end_time',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'Doc_id', 'Doc_id');
    }
}
