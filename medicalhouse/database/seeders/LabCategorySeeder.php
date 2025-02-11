<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LabCategory;

class LabCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lab_categories = [
            'Blood Sugar Tests',
            'Hematology (Blood Tests)',
            'Lipid Profile & Cholesterol Tests',
            'Kidney Function Tests',
            'Liver Function Tests',
            'Protein Tests',
            'Infectious Disease Tests',
            'Urine Tests',
            'Seminal Fluid Analysis',
            'Special Tests'
        ];
        
        foreach ($lab_categories as $key => $categoryName) {
            LabCategory::create([
                'name' => $categoryName
            ]);
        }

    }
}
