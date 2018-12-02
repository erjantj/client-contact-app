<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tokens extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('token');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('token', function (Blueprint $table) {
            $table->increments('id');
            $table->string('token');
            $table->string('client_id');
            $table->timestamps();
            $table->softDeletes();
        });

        \App\Models\Token::create([
            'id' => 1,
            'token' => 'c5aa7a2367eba62037bc9515ebc579002f57e4fc',
            'client_id' => 2,
        ]);

    }
}
