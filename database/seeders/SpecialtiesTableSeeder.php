<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SpecialtiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('specialties')->truncate();
        
        $specialties =  [
            ['id' => Str::uuid(), 'name' => 'anesthesiology'],
            ['id' => Str::uuid(), 'name' => 'audiology'],
            ['id' => Str::uuid(), 'name' => 'cardiology'],
            ['id' => Str::uuid(), 'name' => 'critical_care_medicine'],
            ['id' => Str::uuid(), 'name' => 'dermatology'],
            ['id' => Str::uuid(), 'name' => 'endocrinology'],
            ['id' => Str::uuid(), 'name' => 'family_medicine'],
            ['id' => Str::uuid(), 'name' => 'gastroenterology'],
            ['id' => Str::uuid(), 'name' => 'geriatrics'],
            ['id' => Str::uuid(), 'name' => 'hematology'],
            ['id' => Str::uuid(), 'name' => 'infectious_disease'],
            ['id' => Str::uuid(), 'name' => 'internal_medicine'],
            ['id' => Str::uuid(), 'name' => 'nephrology'],
            ['id' => Str::uuid(), 'name' => 'neurology'],
            ['id' => Str::uuid(), 'name' => 'neurosurgery'],
            ['id' => Str::uuid(), 'name' => 'obstetrics'],
            ['id' => Str::uuid(), 'name' => 'gynecology'],
            ['id' => Str::uuid(), 'name' => 'oncology'],
            ['id' => Str::uuid(), 'name' => 'ophthalmology'],
            ['id' => Str::uuid(), 'name' => 'orthopedics'],
            ['id' => Str::uuid(), 'name' => 'otolaryngology'],
            ['id' => Str::uuid(), 'name' => 'palliative_care'],
            ['id' => Str::uuid(), 'name' => 'pathology'],
            ['id' => Str::uuid(), 'name' => 'pediatrics'],
            ['id' => Str::uuid(), 'name' => 'physical_medicine_and_rehabilitation'],
            ['id' => Str::uuid(), 'name' => 'plastic_surgery'],
            ['id' => Str::uuid(), 'name' => 'podiatry'],
            ['id' => Str::uuid(), 'name' => 'preventive_medicine'],
            ['id' => Str::uuid(), 'name' => 'psychiatry'],
            ['id' => Str::uuid(), 'name' => 'pulmonology'],
            ['id' => Str::uuid(), 'name' => 'radiology'],
            ['id' => Str::uuid(), 'name' => 'rheumatology'],
            ['id' => Str::uuid(), 'name' => 'sports_medicine'],
            ['id' => Str::uuid(), 'name' => 'surgery'],
            ['id' => Str::uuid(), 'name' => 'thoracic_surgery'],
            ['id' => Str::uuid(), 'name' => 'urology'],
            ['id' => Str::uuid(), 'name' => 'vascular_surgery'],
        ];

        DB::table('specialties')->insert($specialties);
    }
}
