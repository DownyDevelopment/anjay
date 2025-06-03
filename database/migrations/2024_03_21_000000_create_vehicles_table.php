<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('license_plate')->unique();
            $table->string('brand');
            $table->string('model');
            $table->string('color');
            $table->string('student_name');
            $table->string('student_id')->unique();
            $table->string('vehicle_type'); // car, motorcycle, etc.
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}; 