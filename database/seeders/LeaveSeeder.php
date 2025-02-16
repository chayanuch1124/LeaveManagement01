<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LeaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('leaves')->insert([
            [
                'employee_id' => 1, // พนักงานคนที่ 1
                'type' => 'Sick Leave',
                'start_date' => Carbon::now()->subDays(2)->toDateString(),
                'end_date' => Carbon::now()->toDateString(),
                'status' => 'approved',
                'reason' => 'ป่วยเป็นไข้หวัด',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 2, // พนักงานคนที่ 2
                'type' => 'Vacation',
                'start_date' => Carbon::now()->addDays(3)->toDateString(),
                'end_date' => Carbon::now()->addDays(7)->toDateString(),
                'status' => 'pending',
                'reason' => 'ไปเที่ยวกับครอบครัว',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);
    }
}
