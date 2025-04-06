<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('blood_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('admin_id');
            $table->string('user_name');
            $table->string('email');
            $table->string('phone');
            $table->string('blood_group');
            $table->integer('blood_quantity');
            $table->enum('request_type', ['Emergency', 'Rare', 'Normal']);
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->string('request_form');
            $table->decimal('payment', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('blood_requests');
    }
};
