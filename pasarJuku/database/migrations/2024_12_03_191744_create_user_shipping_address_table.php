
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
        Schema::dropIfExists('user_shippingAddress');
        Schema::create('user_shippingAddress', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('user_shippingAddressID');
            $table->unsignedBigInteger('userID');
            $table->unsignedBigInteger('shipping_addressID');
            $table->timestamps(); 

            $table->index(["userID"], 'userID_idx');

            $table->index(["shipping_addressID"], 'shipping_addressID_idx');


            $table->foreign('userID')
                ->references('userID')->on('users')
                ->onDelete('cascade');

            $table->foreign('shipping_addressID')
                ->references('shippingAddressID')->on('shippingAddress')
                ->onDelete('cascade');

        });
 Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('user_shippingAddress');
    }
};
