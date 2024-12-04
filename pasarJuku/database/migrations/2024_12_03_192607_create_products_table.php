
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
        Schema::dropIfExists('products');
        Schema::create('products', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('productsID');
            $table->unsignedBigInteger('businessProfileID');
            $table->string('name', 100);
            $table->text('description');
            $table->integer('price');
            $table->integer('stock');
            $table->integer('categoryID');

            $table->index(["businessProfileID"], 'businessID_idx');

            $table->index(["categoryID"], 'categoryID_idx');


            $table->foreign('businessProfileID')
                ->references('businessProfileID')->on('businessProfile')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('categoryID')
                ->references('categoryID')->on('category')
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
        Schema::dropIfExists('products');
    }
};
