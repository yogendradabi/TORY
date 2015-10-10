<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateITEMSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ITEMS', function (Blueprint $table) {
            $table->bigIncrements('itemId');
            $table->string('productId');
            $table->string('affiliateUrl');
            $table->string('imagePath');
            $table->integer('price');
            $table->integer('rating');
            $table->string('color');
            $table->boolean('available')->default(1);
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
        Schema::drop('ITEMS');
    }
}
