<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonateBlood extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id',
        'status',
        'request_form',
        'blood_quantity',
        'blood_type',
        'user_name',
        'email',
        'phone',
        'donation_date',
    ];

    protected $casts = [
        'donation_date' => 'datetime',
    ];

    protected $appends = ['file_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function getFileUrlAttribute()
    {
        return $this->request_form ? asset($this->request_form) : null;
    }

    public function canEdit()
    {
        return $this->status === 'pending';
    }

    public function getStatusBadgeAttribute()
    {
        $status = strtolower($this->status);
        $badges = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'completed' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            'cancelled' => 'bg-gray-100 text-gray-800'
        ];
        return $badges[$status] ?? 'bg-blue-100 text-blue-800';
    }
    public function getBloodTypeAttribute($value)
    {
        return strtoupper(str_replace(' ', '', $value));
    }

    public function setBloodTypeAttribute($value)
    {
        $this->attributes['blood_type'] = strtoupper(str_replace(' ', '', $value));
    }
}
