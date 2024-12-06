
<?php
        /**
     *namespace Database\Migrations;
     */


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
        Schema::dropIfExists('payment_process');
        Schema::create('payment_process', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('payment_processID');
            $table->unsignedBigInteger('orderID');
            $table->unsignedBigInteger('paymentID');
            $table->integer('total_price');
            $table->enum('payment_status', ['pending', 'success']);
            $table->timestamps();

            $table->unique(["ordersID"], 'ordersID_UNIQUE'); // one to one

            $table->index(["paymentID"], 'paymentID_idx');

            $table->index(["ordersID"], 'order_detailsID_idx');


            $table->foreign('orderID')
                ->references('orderID')->on('orders')
                ->onDelete('cascade');


            $table->foreign('paymentID')
                ->references('paymentID')->on('payment')
                ->onDelete('cascade');

        });
 Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('payment_process');
    }
};
