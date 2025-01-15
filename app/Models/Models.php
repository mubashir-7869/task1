<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD

class Models extends Model
{
    use HasFactory;
=======
use Illuminate\Database\Eloquent\SoftDeletes;

class Models extends Model
{
    use HasFactory,SoftDeletes;
>>>>>>> e4491ad02c969cb118a302ba4fe54e8255d2e498
    protected $fillable = ['name', 'brand_id'];
    
    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function items(){
        return $this->hasMany(Item::class, 'model_id', 'id');
    }
}
