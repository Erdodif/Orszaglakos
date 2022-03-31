<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    public $table = 'varosok';
    protected $hidden = ['created_at','updated_at'];
    public $fillable = ['nev','orszag','lakossag'];
}
