<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FunFact extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'count',
    ];
}
