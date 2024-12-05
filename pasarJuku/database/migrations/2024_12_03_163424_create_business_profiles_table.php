
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
        Schema::dropIfExists('businessProfile');
        Schema::create('businessProfile', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('businessProfileID'); //pk
            $table->unsignedBigInteger('userID'); // fk
            $table->string('business_name');
            $table->string('business_address');
            $table->string('SIUP'); 
            $table->string('bank_account');
            $table->tinyInteger('verified_status')->default(0); // Default 0 = not verified
            $table->timestamps(); 

            $table->unique('userID', 'userID_UNIQUE'); 
            // foreign key
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
        Schema::dropIfExists('businessProfile');
    }
};
