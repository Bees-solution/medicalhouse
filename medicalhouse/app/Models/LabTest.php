<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\LabCategory;

class LabTest extends Model
{
    protected $fillable = ['name', 'fname', 'description', 'price', 'lab_category_id', 'slug'];

    public static function boot(){
        parent::boot();

        static::creating(function ($labTest) {
            if (empty($labTest->slug)) {
                $labTest->slug = Str::slug($labTest->name);
            }
        });
    
        static::updating(function ($labTest) {
            if ($labTest->isDirty('name')) {
                $labTest->slug = Str::slug($labTest->name);
            }
        });
    }

    public function category() {
        return $this->belongsTo(LabCategory::class, 'lab_category_id');
    }

}
