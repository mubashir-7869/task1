<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 013a8dde3db08e069247b22a6fa0da7d4396f557

class Brand extends Model
{
    use HasFactory;
<<<<<<< HEAD
=======
=======
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory,SoftDeletes;
>>>>>>> e4491ad02c969cb118a302ba4fe54e8255d2e498
>>>>>>> 013a8dde3db08e069247b22a6fa0da7d4396f557
    protected $fillable = ['name'];

    public function items(){
        return $this->hasMany(Item::class, 'brand_id', 'id');
    }
    public function models(){
        return $this->hasMany(Models::class, 'brand_id', 'id');
    }
}
