<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmountLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amount_limits', function (Blueprint $table) {
            $table->id();
            $table->Integer('user_id');
            $table->String('unique_id',191);
            $table->DateTime('amount_limit');
            $table->DateTime('date_limit');
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
        Schema::dropIfExists('amount_limits');
    }
}
