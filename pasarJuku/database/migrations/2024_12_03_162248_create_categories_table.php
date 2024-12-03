
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
        Schema::dropIfExists('category');
        Schema::create('category', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('categoryID');
            $table->enum('category', [
                'Ikan Mas',
                'Ikan Nila',
                'Ikan Lele',
                'Ikan Patin',
                'Ikan Gurame',
                'Ikan Mujair',
                'Ikan Gabus',
                'Ikan Bawal',
                'Udang Air Tawar',
                'Teri Air Tawar',
                'Belut'
            ]);
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('category');
    }
};
