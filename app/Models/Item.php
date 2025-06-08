<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'items';
    public $keyType  = 'string';
    public $incrementing = false; 

    public function medical_unit(){
        return $this->belongsTo(MedicalUnit::class);
    }

    public function category(){
        return $this->belongsTo(ItemCategory::class, 'cat_id', 'id');
    }

    public function area(){
        return $this->belongsTo(AreaCategory::class, 'area_id', 'id');
    }
}