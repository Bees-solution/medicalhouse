<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'bill_date',
        'bill_no'
    ];

    // Auto-generate bill_no like B25485
    protected static function booted()
    {
        static::creating(function ($bill) {
            $latest = Bill::orderBy('id', 'desc')->first();
            $lastNumber = $latest ? intval(substr($latest->bill_no, 1)) : 25480;
            $bill->bill_no = 'B' . ($lastNumber + 1);
        });
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}

