<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTerminabstimmungTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terminabstimmung', function (Blueprint $table) {
            $table->id('id')->autoIncrement();
            $table->timestamps();
            $table->foreignId("fk_chat_id")->references("id")->on("chat");
            $table->string("namen")->nullable();
            $table->timestamp("open_till")->nullable();
            $table->timestamp("won_date")->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('terminabstimmung');
    }
}
