<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class AreaCategory extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'area_categories';
    public $keyType  = 'string';
    public $incrementing = false;

    public function items(){
        return $this->hasMany(Item::class, 'area_id', 'id');
    }
}