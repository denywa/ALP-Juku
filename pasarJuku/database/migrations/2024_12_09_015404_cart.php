
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
        Schema::dropIfExists('cart');
        Schema::create('cart', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedBigInteger('userID');
            $table->unsignedBigInteger('productID');
            $table->integer('quantity');

            $table->index(["userID"], 'userID_idx');

            $table->index(["productID"], 'productID_idx');


            $table->foreign('userID')
                ->references('userID')->on('users')
                ->onDelete('cascade');

            $table->foreign('productID')
                ->references('productID')->on('products')
                ->onDelete('cascade');
        });
 Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('cart');
    }
};
