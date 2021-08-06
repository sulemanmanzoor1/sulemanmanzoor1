<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('salon_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('password');
            $table->integer('country_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->string('image');
            $table->integer('status')->default(0)->comment = '0=deactive 1=active';
            $table->float('wallet')->default(0.00);
            $table->rememberToken();
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
        Schema::dropIfExists('salons');
    }
}
