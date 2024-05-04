<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_details', function (Blueprint $table) {
            $table->id();
            $table->String('unique_id');
            $table->Integer('user_id');
            $table->String('customer_name');
            $table->String('bill_number');
            $table->String('bill_date');
            $table->String('bill_amount');
            $table->String('due_date');
            $table->String('operator');
            $table->String('status')->comments('1 for pending 2 for accepted 3 for rejected');
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
        Schema::dropIfExists('bill_details');
    }
}
