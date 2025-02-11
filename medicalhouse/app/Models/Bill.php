<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'bill_date'
    ];

    // Relationship: A Bill belongs to a Payment
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
