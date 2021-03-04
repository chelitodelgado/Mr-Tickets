<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    // Tickets
    protected $table = "ticket";

    protected $fillable = [
        'title',
        'description',
        'kind_id',
        'user_id',
        'project_id',
        'category_id',
        'priority_id',
        'status_id'
    ];

}
