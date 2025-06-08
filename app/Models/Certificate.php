<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'certificates';
    public $keyType  = 'string';
    public $incrementing = false;

    public function patient(){
        return $this->belongsTo(Patient::class);
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }
}