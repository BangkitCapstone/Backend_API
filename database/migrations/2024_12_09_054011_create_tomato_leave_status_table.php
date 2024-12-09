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
        Schema::create('tomato_leave_status', function (Blueprint $table) {
            $table->id(); // id int(11) AI PK
            $table->string('status_name', 45); // status_name varchar(45)
            $table->longText('healing_steps'); // healing_steps longtext
            $table->timestamps(); // created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('tomato_leave_status');
    }
};
