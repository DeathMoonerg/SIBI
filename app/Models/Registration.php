<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_name',
        'child_name',
        'grade',
        'phone',
        'message',
        'status',
    ];
} 
 
 
 
 