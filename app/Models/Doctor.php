<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'doctors';
    public $keyType  = 'string';
    public $incrementing = false;
    
    protected $casts = [
        'specialties' => 'array',  
    ]; 

    public function getSpecialtiesAttribute($value){
        return $value ?? [];  
    }

    public function appointments(){
        return $this->hasMany(Appointment::class);
    }
}