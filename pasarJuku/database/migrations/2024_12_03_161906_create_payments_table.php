<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class  extends Migration
{
        /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('payment');
        Schema::create('payment', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('paymentID');
            $table->enum('payment_type', ['BCA', 'gopay', 'DANA', 'OVO']);
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('payment');
    }
};
