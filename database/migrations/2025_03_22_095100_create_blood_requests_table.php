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
        Schema::create('blood_requests', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key (equivalent to INT(10) UNSIGNED PRIMARY KEY AUTO_INCREMENT)
            $table->unsignedBigInteger('user_id'); // Equivalent to INT(10) UNSIGNED
            $table->unsignedBigInteger('admin_id'); // Equivalent to INT(10) UNSIGNED
            $table->enum('request_type', ['Emergency', 'Rare', 'Normal']); // ENUM column
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending'); // ENUM column with default value
            $table->string('request_form', 255); // VARCHAR(255) column
            $table->decimal('payment', 10, 2)->nullable(); // Payment column (DECIMAL with 10 digits, 2 decimal places)
            $table->timestamps(); // created_at and updated_at timestamps

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blood_requests');
    }
};
