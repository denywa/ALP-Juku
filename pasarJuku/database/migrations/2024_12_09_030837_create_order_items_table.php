
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
        Schema::dropIfExists('order_items');
        Schema::create('order_items', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('order_itemID');
            $table->unsignedBigInteger('productID');
            $table->integer('quantity');
            $table->unsignedBigInteger('orderID');
            $table->timestamps();
            $table->index(["productID"], 'productID_idx');

            $table->index(["orderID"], 'orderID_idx');


            $table->foreign('productID')
                ->references('productID')->on('products')
                ->onDelete('cascade');


            $table->foreign('orderID')
                ->references('orderID')->on('orders')
                ->onDelete('cascade');

        });
 Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};
