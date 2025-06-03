<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id',
        'user_name',
        'email',
        'phone',
        'blood_group',
        'blood_quantity',
        'request_type',
        'status',
        'request_form',
        'payment',
        'payment_status',
        'transaction_id'

    ];

    protected $attributes = [
        'status' => 'Pending',
        'payment' => 0
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
    public function canEdit()
    {
        return strtolower($this->status) === 'pending';
    }

    public function getFileUrlAttribute()
    {
        return $this->request_form ? asset($this->request_form) : null;
    }
}
