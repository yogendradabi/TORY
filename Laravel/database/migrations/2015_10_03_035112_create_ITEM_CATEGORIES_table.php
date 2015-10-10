<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateITEMCATEGORIESTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ITEM_CATEGORIES', function (Blueprint $table) {
   //         $table->increments('id');
            $table->bigInteger('categoryId')->unsigned();
            $table->bigInteger('itemId')->unsigned();
            $table->foreign('categoryId')->references('categoryId')->on('CATEGORIES')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('itemId')->references('itemId')->on('ITEMS')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::drop('ITEM_CATEGORIES');
    }
}
