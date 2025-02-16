<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $table = 'leaves'; // กำหนดชื่อตารางในฐานข้อมูล

    protected $fillable = [
        'employee_id',
        'type',
        'start_date',
        'end_date',
        'reason',
        'status',
    ];

    /**
     * สร้างความสัมพันธ์กับ Employee
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
