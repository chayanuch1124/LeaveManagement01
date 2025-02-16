<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade'); // FK ไปยัง employees
            $table->string('type'); // ประเภทการลา เช่น ลาป่วย, ลากิจ
            $table->date('start_date'); // วันที่เริ่มลา
            $table->date('end_date'); // วันที่สิ้นสุด
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // สถานะใบลา
            $table->text('reason')->nullable(); // เหตุผลการลา
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('leaves');
    }
};
