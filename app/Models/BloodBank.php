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
        'A+',
        'A-',
        'B+',
        'B-',
        'AB+',
        'AB-',
        'O+',
        'O-'
    ];

    // Relationship with Admin (optional)
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    // Default blood availability structure
    public function updateBloodStock($bloodType, $quantity)
    {
        if ($quantity < 0 && abs($quantity) > $this->$bloodType) {
            return false; // Not enough blood to deduct
        }

        $this->$bloodType += $quantity;
        $this->save();
        return true;
    }

    public function getAvailableBloodTypes()
    {
        $types = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        $available = [];

        foreach ($types as $type) {
            if ($this->$type > 0) {
                $available[$type] = $this->$type;
            }
        }

        return $available;
    }
}
