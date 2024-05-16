<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppendiciesItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appendicies_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_appendix');
            $table->string('description');
            $table->tinyInteger('vat_percentage')->default(0);
            $table->string('uom');
            $table->decimal('quantity');
            $table->decimal('unit_price');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appendicies_items');
    }
}
