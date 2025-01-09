
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
        Schema::dropIfExists('reviews');
        Schema::create('reviews', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id(column: 'reviewID');
            $table->unsignedBigInteger('userID');
            $table->unsignedBigInteger('order_itemID');
            $table->integer('rating');
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->unique(["order_itemID"], 'order_itemID_UNIQUE'); // one to one

            $table->index(["order_itemID"], 'order_itemID_idx');

            $table->index(["userID"], 'userID_idx');


            $table->foreign('order_itemID')
                ->references('order_itemID')->on('order_items')
                ->onDelete('cascade');


            $table->foreign('userID')
                ->references('userID')->on('users')
                ->onDelete('cascade');

        });
 Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
