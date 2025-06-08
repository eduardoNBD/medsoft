<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'patients';
    public $keyType  = 'string';
    public $incrementing = false;

    public function appointments(){
        return $this->hasMany(Appointment::class);
    } 

    public function encounters(){
        return $this->hasMany(Encounter::class);
    } 
}