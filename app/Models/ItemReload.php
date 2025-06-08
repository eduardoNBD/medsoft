<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ItemReload extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'item_reloads';
    public $keyType  = 'string';
    public $incrementing = false;  
}