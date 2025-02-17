<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->timestamps(); // สร้าง created_at และ updated_at
            $table->id();
            $table->string('name')->nullable();
            $table->string('phone')->nullable(); // เบอร์โทรศัพท์
            $table->string('position')->nullable(); // ตำแหน่งงาน
            $table->string('email')->nullable();
            $table->integer('leave_balance')->default(10); // จำนวนวันลาที่เหลือ
            $table->string('photo')->nullable(); // URL รูปโปรไฟล์
            $table->string('password'); // รหัสผ่าน (เข้ารหัส Hash)
            $table->string('role')->nullable();
            $table->integer('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
