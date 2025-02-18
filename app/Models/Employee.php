<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'employees'; // กำหนดชื่อตาราง
    protected $primaryKey = 'id'; // กำหนด Primary Key
    public $timestamps = true; // เปิดใช้งาน timestamps (created_at, updated_at)

    // กำหนดฟิลด์ที่สามารถกรอกได้
    protected $fillable = [
        'name',
        'email',
        'phone',
        'position',
        'leave_balance',
        'photo',
        'password',
        'user_id'
    ];

    // ซ่อนฟิลด์ที่ไม่ควรเปิดเผย
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ฟังก์ชันเข้ารหัสรหัสผ่านโดยอัตโนมัติเมื่อบันทึกข้อมูล
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    // ความสัมพันธ์: Employee มีหลายใบลา (One-to-Many)
    public function leaves()
    {
        return $this->hasMany(Leave::class, 'employee_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    

}
