<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
    ];

    protected $hidden = [
        'password',
    ];

    public function bloodBank()
    {
        return $this->hasOne(BloodBank::class, 'admin_id');
    }
}
