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

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function updateStock($bloodType, $quantity)
    {
        if ($quantity < 0 && abs($quantity) > $this->$bloodType) {
            return false; // Not enough blood to deduct
        }

        $this->$bloodType += $quantity;
        $this->save();
        return true;
    }

    public static function currentAdminBank()
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            abort(403, 'Unauthorized - Admin not logged in');
        }

        return self::firstOrCreate(
            ['admin_id' => $admin->id],
            ['admin_name' => $admin->name ?? 'Admin']
        );
    }
}
