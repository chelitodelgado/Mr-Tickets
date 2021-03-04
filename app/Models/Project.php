<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    // Categoria
    protected $table = "project";

    protected $fillable = [
        'name',
        'description'
    ];

}
