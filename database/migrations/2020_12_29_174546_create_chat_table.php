<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat', function (Blueprint $table) {
            $table->id('id')->autoIncrement();
            // $uuid = DB::raw('UUID()');
            $table->uuid("uuid")->nullable();//default($uuid);
            $table->string("url")->nullable();
            $table->boolean("type")->default(false);
            $table->foreignId("team_id")->references("id")->on("teams");
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
        Schema::dropIfExists('chat');
    }
}
