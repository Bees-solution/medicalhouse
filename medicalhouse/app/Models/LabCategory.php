<?php

namespace App\Models;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Model;

class LabCategory extends Model
{
    protected $fillable = ['name', 'slug'];

    public static function boot(){
        parent::boot();
        static::creating(function($lab_category) {
            $lab_category->slug = Str::slug($lab_category->name);
            //check if the slug is already exist for any post
            $slugCount = LabCategory::where('slug', $lab_category->slug)->count();
            if($slugCount > 0) {
                $lab_category->slug .= '-'.($slugCount + 1); //Append a number to make it unique
            }
        });
    }
}
