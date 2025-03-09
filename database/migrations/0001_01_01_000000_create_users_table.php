<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('age');
            $table->decimal('weight', 5, 2); // Weight in kg (e.g., 70.5)
            $table->string('address');
            $table->string('phone');
            $table->string('blood_type'); // e.g., A+, O-, etc.
            $table->enum('user_type', ['admin', 'receiver', 'donor']); // User role
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
