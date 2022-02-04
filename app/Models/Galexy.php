<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galexy extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'about', 'light_years'];
}
