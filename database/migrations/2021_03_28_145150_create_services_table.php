<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('service_name');
            $table->string('service_price');
            $table->string('service_time');
            $table->string('category_id');
            $table->string('salon_id');
            $table->string('image');
            $table->integer('is_discount')->comment = '0=no discount 1=discount';
            $table->double('discount');
            $table->integer('status')->default(1)->comment = '0=deactivate 1=active';
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
        Schema::dropIfExists('services');
    }
}
