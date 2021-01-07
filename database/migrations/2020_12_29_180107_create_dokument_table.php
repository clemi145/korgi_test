<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDokumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dokument', function (Blueprint $table) {
            $table->timestamps();
            $table->foreignId("fk_pk_chat_id")->references("id")->on("chat");
            $table->bigInteger("filesize")->nullable();
            $table->string("filetype")->nullable();
            $table->string("flob")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dokument');
    }
}
