<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKYCFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('k_y_c_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('grandfather_name');
            $table->string('spouse_name');
            $table->string('occupation');
            $table->string('district');
            $table->string('municipality');
            $table->string('ward_number');
            $table->string('identity_type');
            $table->string('identity_number');
            $table->string('issued_date');

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
        Schema::dropIfExists('k_y_c_forms');
    }
}
