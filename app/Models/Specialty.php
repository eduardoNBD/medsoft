<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'specialties';
    public $keyType  = 'string';
    public $incrementing = false;
    protected $fillable = [
        'name', 
    ];
}