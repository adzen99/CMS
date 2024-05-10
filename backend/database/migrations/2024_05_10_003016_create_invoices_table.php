<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('series');
            $table->unsignedBigInteger('number');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_company');
            $table->unsignedBigInteger('id_partner');
            $table->unsignedBigInteger('id_contract');
            $table->unsignedBigInteger('id_appendix');
            $table->date('date');
            $table->date('due_date');
            $table->string('currency');
            $table->decimal('value');
            $table->decimal('vat');
            $table->tinyInteger('vat_percentage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
