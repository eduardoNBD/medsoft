<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'appointments';
    public $keyType  = 'string';
    public $incrementing = false; 
    protected $casts = [ 
        'end_date' => 'datetime',
    ];

    public function patient(){
        return $this->belongsTo(Patient::class);
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }
}