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
        Schema::create('upload_histories', function (Blueprint $table) {
            $table->id(); // id int(11) PK
            $table->string('image_path', 45); // image_path varchar(45)
            $table->unsignedBigInteger('users_id'); // users_id int(10) UN
            $table->unsignedBigInteger('status_id'); // status_id int(11)
            $table->timestamp('date')->useCurrent(); // date timestamp
            $table->timestamps(); // created_at and updated_at

            // Foreign keys
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('tomato_leave_status')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('upload_histories');
    }
};
