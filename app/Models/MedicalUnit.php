<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class MedicalUnit extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'medical_units';
    public $keyType  = 'string';
    public $incrementing = false;  
}