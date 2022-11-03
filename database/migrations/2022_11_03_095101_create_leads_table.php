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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();

            $table->integer('contact_id');
            $table->integer('lead_id');
            $table->string('lead_status');

            $table->integer('wallet');
            $table->string('type');
            $table->string('email');
            $table->string('method');
            $table->integer('send_cost');
            $table->string('send_currency');
            $table->integer('need_cost');
            $table->string('need_currency');

            $table->string('exchange_rate');

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
        Schema::dropIfExists('leads');
    }
};
