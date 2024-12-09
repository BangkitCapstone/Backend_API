<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // id int(10) UN AI PK
            $table->string('username', 45); // username varchar(45)
            $table->string('password', 255); // password varchar(255)
            $table->string('profile_picture', 45)->nullable(); // profile_picture varchar(45)
            $table->string('email', 45)->unique(); // email varchar(45)
            $table->timestamps(); // created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
