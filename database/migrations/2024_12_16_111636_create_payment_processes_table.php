<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('paymentprocesses', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Specify the storage engine
            $table->bigIncrements('paymentProcessID');
            $table->unsignedBigInteger('orderID');
            $table->foreign('orderID')->references('orderID')->on('orders');
            $table->unsignedBigInteger('paymentID');
            $table->foreign('paymentID')->references('paymentID')->on('payments');
            $table->integer('total_price');
            $table->string('payment_status');
            $table->dateTime('payment_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paymentprocesses');
    }
};
