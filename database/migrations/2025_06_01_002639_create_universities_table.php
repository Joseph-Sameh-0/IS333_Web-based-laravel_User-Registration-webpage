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
        Schema::create('students', function (Blueprint $table) {
            $table->id('student_id');
            $table->string('user_role', 20)->default('user');
            $table->string('user_name', 50)->unique();
            $table->string('full_name', 255);
            $table->string('phone', 20);
            $table->string('whatsup_number', 20);
            $table->text('address');
            $table->string('password', 255);
            $table->string('email', 255)->unique();
            $table->string('student_img', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('universities');
    }
};
