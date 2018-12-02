<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Client extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('client');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email');
            $table->timestamps();
            $table->softDeletes();
        });

        \App\Models\Client::create([
            'id' => 1,
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@example.com',
        ]);
    }
}
