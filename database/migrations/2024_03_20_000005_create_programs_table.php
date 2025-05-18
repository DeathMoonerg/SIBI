<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->string('duration')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('status')->default('active');
            $table->string('level')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('name', 'idx_name');
            $table->index('status', 'idx_status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('programs');
    }
}; 