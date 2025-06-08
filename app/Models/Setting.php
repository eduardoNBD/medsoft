<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'settings';
    public $keyType  = 'string';
    public $incrementing = false;
    protected $fillable = [
        'key',
        'value',
        'module'
    ];
}