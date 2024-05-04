<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeFreezesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_freezes', function (Blueprint $table) {
            $table->id();
            $table->String('unique_id',191);
            $table->DateTime('time_limit');
            $table->DateTime('date_limit');
            $table->DateTime('upto_time');
            $table->DateTime('upto_date');
            $table->TinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_freezes');
    }
}
