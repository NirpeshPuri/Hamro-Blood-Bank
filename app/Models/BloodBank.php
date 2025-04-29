<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BloodBank extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'admin_name',
        'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'
    ];

    protected $attributes = [
        'A+' => 0,
        'A-' => 0,
        'B+' => 0,
        'B-' => 0,
        'AB+' => 0,
        'AB-' => 0,
        'O+' => 0,
        'O-' => 0,
    ];

    public static function bloodGroups()
    {
        return ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
    }
    public $timestamps = false;


    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function getBloodGroupQuantity($group)
    {
        $group = $this->normalizeBloodGroup($group);
        return $this->$group ?? 0;
    }

    public function updateStock($bloodType, $quantity)
    {
        $bloodType = $this->normalizeBloodGroup($bloodType);

        $current = $this->$bloodType ?? 0;
        $newQuantity = $current + $quantity;

        if ($newQuantity < 0) {
            throw new \Exception("Not enough {$bloodType} blood available (current: {$current}, requested: " . abs($quantity) . ")");
        }

        $this->$bloodType = $newQuantity;

        if (!$this->save()) {
            throw new \Exception("Failed to update blood bank records");
        }

        return true;
    }

    public static function currentAdminBank()
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            throw new \Exception('Admin authentication required');
        }

        return self::firstOrCreate(
            ['admin_id' => $admin->id],
            ['admin_name' => $admin->name ?? 'Admin']
        );
    }

    protected function normalizeBloodGroup($group)
    {
        $group = strtoupper(str_replace(' ', '', $group));

        if (!in_array($group, self::bloodGroups())) {
            throw new \Exception("Invalid blood type: {$group}. Valid types are: " . implode(', ', self::bloodGroups()));
        }

        return $group;
    }
}
