<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->timestamp('entry_time')->useCurrent();
        });
    }

    public function down()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn('entry_time');
        });
    }
}; 