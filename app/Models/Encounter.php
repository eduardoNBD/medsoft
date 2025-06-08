<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Encounter extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'encounters';
    public $keyType  = 'string';
    public $incrementing = false;

    public function patient(){
        return $this->belongsTo(Patient::class);
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }

    public function medical_unit(){
        return $this->belongsTo(MedicalUnit::class);
    }
}