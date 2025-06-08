<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'medical_histories';
    public $keyType  = 'string';
    public $incrementing = false;
    protected $fillable = [
        'patient_id',
        'file_number', // Incluir otros campos según sea necesario
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) { 
            $lastFileNumber = self::max('file_number'); 
            $nextFileNumber = $lastFileNumber ? intval($lastFileNumber) + 1 : 1; 
            $model->file_number = $nextFileNumber;  
        });
    } 
}