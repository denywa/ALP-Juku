
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
        Schema::dropIfExists('shippingAddress');
        Schema::create('shippingAddress', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('shippingAddressID');
            $table->string('address', 100);
            $table->string('city', 100);
            $table->integer('pos_code');
            $table->string('recipient_name', 100);
            $table->string('phone', 45);
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('shippingAddress');
    }
};
