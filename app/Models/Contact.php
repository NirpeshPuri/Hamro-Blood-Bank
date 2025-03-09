<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    // Fields that can be mass-assigned
    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
    ];
}
