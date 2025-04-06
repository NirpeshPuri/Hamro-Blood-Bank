<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodBank extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'admin_name',
        'blood_availability'
    ];

    protected $casts = [
        'blood_availability' => 'array'
    ];

    // Relationship with Admin (optional)
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    // Default blood availability structure
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->blood_availability = $model->blood_availability ?? [
                'A+' => 0, 'A-' => 0,
                'B+' => 0, 'B-' => 0,
                'AB+' => 0, 'AB-' => 0,
                'O+' => 0, 'O-' => 0
            ];
        });
    }
}
