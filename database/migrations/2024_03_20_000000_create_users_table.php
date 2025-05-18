<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->enum('role', ['admin', 'teacher', 'parent', 'student'])->default('parent');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('parent_email')->nullable();
            $table->string('program')->nullable();
            $table->string('grade')->nullable();
            $table->date('birthdate')->nullable();
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}; 