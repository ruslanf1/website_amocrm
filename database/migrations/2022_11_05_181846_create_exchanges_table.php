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
        Schema::create('exchanges', function (Blueprint $table) {
            $table->id();

            $table->integer('contact_id');
            $table->integer('lead_id')->unique();
            $table->string('lead_status')->default('Ждем оплату');
            $table->string('wallet');
            $table->string('type_exchange');
            $table->string('email');
            $table->string('method_pay');
            $table->float('send_cost');
            $table->string('send_currency');
            $table->float('need_cost');
            $table->string('need_currency');
            $table->float('exchange_rate');

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
        Schema::dropIfExists('exchanges');
    }
};
