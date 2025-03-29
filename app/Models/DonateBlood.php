<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonateBlood extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'admin_id', 'status', 'request_form','blood_quantity','blood_group','user_name','email','phone',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Admin
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
