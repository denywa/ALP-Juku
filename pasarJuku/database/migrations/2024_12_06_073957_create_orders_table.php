
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
        Schema::dropIfExists('orders');
        Schema::create('orders', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('orderID');
            $table->unsignedBigInteger('user_shippingAddressID')->nullable();
            $table->enum('order_status', ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled']);
            $table->timestamps(); 

            $table->index(["user_shippingAddressID"], 'user_shippingAddressID_idx');


            $table->foreign('user_shippingAddressID')
                ->references('user_shippingAddressID')->on('user_shippingaddress')
                ->onDelete('cascade');
        });
 Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
