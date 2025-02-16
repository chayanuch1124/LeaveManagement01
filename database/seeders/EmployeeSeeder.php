<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        DB::table('employees')->insert([
            [
                'name' => 'สมชาย ใจดี',
                'email' => 'somchai@example.com',
                'phone' => '0812345678',
                'position' => 'นักพัฒนาเว็บ',
                'leave_balance' => 10,
                'photo' => 'https://i.pinimg.com/736x/fc/05/93/fc05937bc2eb4e0ed4b01d7a7ed8bab9.jpg',
                'password' => Hash::make('password'),
                'user_id' => 1,
            ],
            [
                'name' => 'สมหญิง สวยงาม',
                'email' => 'somsing@example.com',
                'phone' => '0898765432',
                'position' => 'นักออกแบบ UI/UX',
                'leave_balance' => 12,
                'photo' => 'https://i.pinimg.com/736x/1e/0c/3f/1e0c3f8daf12cad7b251b04c9dcd0df0.jpg',
                'password' => Hash::make('password'),
                'user_id' => 2,
            ]
        ]);
    }
}
