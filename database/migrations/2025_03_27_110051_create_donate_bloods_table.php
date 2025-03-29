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
        Schema::create('donate_bloods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Equivalent to INT(10) UNSIGNED
            $table->unsignedBigInteger('admin_id'); // Equivalent to INT(10) UNSIGNED
            $table->string('user_name');
            $table->string('email');
            $table->string('phone');
            $table->string('blood_group');
            $table->integer('blood_quantity');// ENUM column
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending'); // ENUM column with default value
            $table->string('request_form', 255); // VARCHAR(255) column
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donate_bloods');
    }
};
