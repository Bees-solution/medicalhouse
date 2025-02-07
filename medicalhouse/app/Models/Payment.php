<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'method',
        'amount',
        'total',
        'doc_id',
        'remarks'
    ];

    // Relationship with Doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doc_id', 'Doc_id');
    }
}
