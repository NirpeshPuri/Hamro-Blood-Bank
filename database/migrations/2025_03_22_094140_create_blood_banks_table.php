<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateBloodBanksTable extends Migration
{
    public function up()
    {
        Schema::create('blood_banks', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade'); // Link to admins table
            $table->string('admin_name');
            $table->integer('A+')->default(0);
            $table->integer('A-')->default(0);
            $table->integer('B+')->default(0);
            $table->integer('B-')->default(0);
            $table->integer('AB+')->default(0);
            $table->integer('AB-')->default(0);
            $table->integer('O+')->default(0);
            $table->integer('O-')->default(0);
            $table->timestamps(); // created_at and updated_at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('blood_banks');
    }
}
