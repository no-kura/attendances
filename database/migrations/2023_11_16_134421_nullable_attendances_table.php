<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dateTime('punchin')->nullable(true)->change();
            $table->dateTime('punchout')->nullable(true)->change();
            $table->dateTime('working')->nullable(true)->change();
            $table->string('memo')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dateTime('punchin')->nullable(false)->change();
            $table->dateTime('punchout')->nullable(false)->change();
            $table->dateTime('working')->nullable(false)->change();
            $table->string('memo')->nullable(false)->change();
        });
    }
};
