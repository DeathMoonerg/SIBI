<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->date('date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->enum('status', ['present', 'absent', 'late'])->default('present');
            $table->text('notes')->nullable();
            $table->string('meeting_type')->default('regular');
            $table->string('location')->nullable();
            $table->text('material')->nullable();
            $table->timestamps();

            $table->index('date', 'idx_date');
            $table->index('student_id', 'idx_student');
            $table->index('teacher_id', 'idx_teacher');
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}; 