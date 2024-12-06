
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
            $table->integer('ordersID');
            $table->integer('paymentID');
            $table->integer('total_price');
            $table->enum('payment_status', ['pending', 'success']);
            $table->dateTime('payment_date');

            $table->unique(["ordersID"], 'ordersID_UNIQUE');

            $table->index(["paymentID"], 'paymentID_idx');

            $table->index(["ordersID"], 'order_detailsID_idx');


            $table->foreign('ordersID')
                ->references('ordersID')->on('orders')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('paymentID')
                ->references('paymentID')->on('payment')
                ->onDelete('no action')
                ->onUpdate('no action');
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
