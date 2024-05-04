<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->Integer('user_id');
            $table->Date('dob');
            $table->Text('address');
            $table->String('city');
            $table->String('state');
            $table->String('pincode');
            $table->String('pan_no',15);
            $table->String('bank_name',30);
            $table->String('account_holder_name');
            $table->String('ifsc_code',20);
            $table->Text('cheque');
            $table->String('aadhar_no',15);
            $table->String('phone_no');
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
        Schema::dropIfExists('user_details');
    }
}
