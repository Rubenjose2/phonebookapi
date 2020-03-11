<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhonebooklogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phonebooklog', function (Blueprint $table) {
            $table->id();
            $table->integer('idFrom');
            $table->integer('idTo');
            $table->enum('transaction',['inbound','outbound']);
            $table->enum('status',['ok','VM']);
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
        Schema::dropIfExists('phonebooklog');
    }
}
