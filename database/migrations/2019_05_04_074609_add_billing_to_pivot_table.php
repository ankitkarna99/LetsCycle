<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBillingToPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cycle_user', function (Blueprint $table) {
            $table->boolean('billed')->after('paid')->default(0);
            $table->decimal('bill_amount', 11,2)->after('billed')->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cycle_user', function (Blueprint $table) {
            $table->dropColumn('billed');
            $table->dropColumn('bill_amount');
        });
    }
}
