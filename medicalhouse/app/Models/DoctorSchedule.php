<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    use HasFactory;

    protected $table = 'doctor_schedules';

   
    protected $primaryKey = ['Doc_id', 'date', 'start_time', 'end_time'];

    public $incrementing = false;

    public $timestamps = true;

    protected $fillable = [
        'Doc_id',
        'date',
        'start_time',
        'end_time',
    ];

    protected $keyType = 'string';

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'Doc_id', 'Doc_id');
    }
}
