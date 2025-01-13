
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
            $table->id('productID');
            $table->unsignedBigInteger('businessProfileID');
            $table->string('name');
            $table->text('description');
            $table->integer('price');
            $table->enum('unit', ['kg', 'gr', 'liter', 'ml', 'pcs']); // Satuan harga
            $table->integer('stock');
            $table->string('image');
            $table->unsignedBigInteger('categoryID');
            $table->timestamps();


            $table->index(["businessProfileID"], 'businessID_idx');

            $table->index(["categoryID"], 'categoryID_idx');


            $table->foreign('businessProfileID')
                ->references('businessProfileID')->on('businessProfile')
                ->onDelete('cascade');

            $table->foreign('categoryID')
                ->references('categoryID')->on('category')
                ->onDelete('cascade');
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
