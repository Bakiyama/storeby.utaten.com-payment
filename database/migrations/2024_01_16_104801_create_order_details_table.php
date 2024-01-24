<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id'); // TODO@ Change the method to foreign key in actual development
            $table->integer('product_variation_id'); // TODO@ Change the method to foreign key in actual development
            $table->string('product_name');
            $table->string('variation_name');
            $table->text('description');
            $table->integer('quantity');
            $table->integer('price');
            $table->string('ckc_shot_type')->nullable();
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
        Schema::dropIfExists('order_details');
    }
};
