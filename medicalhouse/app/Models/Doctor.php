<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctors';

    protected $primaryKey = 'Doc_id';

    protected $fillable = [
        'name',
        'Type',
        'Fee',
        'No_of_patients',
        'License',
        'gender',
        'dob',
        'Qualification',
        'Specialty',
        'remarks',
        'image', // Fixed the missing comma
    ];

    // Specify the attributes that should be cast to native types
    protected $casts = [
        'dob' => 'date',
        'Fee' => 'decimal:2',
        'No_of_patients' => 'integer',
    ];

    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class, 'Doc_id', 'Doc_id');
    }
}
