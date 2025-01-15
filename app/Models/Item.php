<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'amount', 'brand_id','model_id'];
=======
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['name', 'amount', 'brand_id','model_id','image','quantity','status'];
>>>>>>> e4491ad02c969cb118a302ba4fe54e8255d2e498

    public function brand(){
        return $this->belongsTo(Brand::class);
    }
    public function models(){
        return $this->belongsTo(Models::class ,'model_id', 'id');
    }
}
