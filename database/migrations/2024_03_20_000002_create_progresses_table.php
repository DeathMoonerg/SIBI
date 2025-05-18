<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('progresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->date('date');
            $table->string('start_time');
            $table->string('end_time');
            $table->text('material_covered');
            $table->text('achievements');
            $table->text('challenges');
            $table->integer('score');
            $table->integer('overall_score')->nullable();
            $table->text('notes')->nullable();
            $table->text('parent_comment')->nullable();
            $table->timestamp('parent_comment_at')->nullable();
            $table->text('teacher_reply')->nullable();
            $table->timestamp('teacher_reply_at')->nullable();
            $table->timestamps();

            $table->index('date', 'idx_date');
            $table->index('student_id', 'idx_student');
            $table->index('teacher_id', 'idx_teacher');
        });
    }

    public function down()
    {
        Schema::dropIfExists('progresses');
    }
}; 