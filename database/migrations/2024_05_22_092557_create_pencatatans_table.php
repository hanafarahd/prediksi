<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('pencatatans', function (Blueprint $table) {
            $table->id();
            $table->string('invoice');

            $table->unsignedBigInteger('sale_type');
            $table->foreign('sale_type')->references('id')->on('sales');

            $table->integer('salesman_code');
            $table->foreign('salesman_code')->references('code')->on('salesmans');

            $table->foreignId('customer_group_id')->constrained();

            $table->integer('territory_code');
            $table->foreign('territory_code')->references('code')->on('territories');

            $table->enum('guarantee_letter', ['ada', 'tidak ada']);
            $table->integer('invoice_amount')->unsigned();
            $table->integer('outstanding')->unsigned();
            $table->date('cutoff_date');
            $table->date('due_date');
            $table->date('trans_date');
            $table->integer('exchange_freq');
            $table->integer('bill_freq');
            $table->string('prediction')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pencatatans');
    }
};
