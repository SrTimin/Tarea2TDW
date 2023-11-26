<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perro extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nombre', 'foto_url', 'descripcion'];

    protected $table = 'perros';

    protected $dates = ['deleted_at'];
}