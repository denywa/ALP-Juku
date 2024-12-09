
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
            $table->unsignedBigInteger('productsID');
            $table->integer('quantity');

            $table->index(["userID"], 'userID_idx');

            $table->index(["productsID"], 'productsID_idx');


            $table->foreign('userID')
                ->references('userID')->on('users')
                ->onDelete('cascade');

            $table->foreign('productsID')
                ->references('productsID')->on('products')
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
