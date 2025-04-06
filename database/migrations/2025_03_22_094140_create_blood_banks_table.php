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
            $table->json('blood_availability');
            $table->timestamps(); // created_at and updated_at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('blood_banks');
    }
}
