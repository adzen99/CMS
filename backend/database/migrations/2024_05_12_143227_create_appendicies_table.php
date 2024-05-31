<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppendiciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appendicies', function (Blueprint $table) {
            $table->id();
            $table->string('series');
            $table->unsignedBigInteger('no');
            $table->date('date');
            $table->unsignedBigInteger('id_provider');
            $table->unsignedBigInteger('id_beneficiary');
            $table->unsignedBigInteger('id_contract');
            $table->unsignedBigInteger('id_invoice')->default(0);
            $table->string('currency');
            $table->decimal('value')->default(0);
            $table->decimal('vat')->default(0);
            $table->tinyInteger('vat_percentage')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appendicies');
    }
}
