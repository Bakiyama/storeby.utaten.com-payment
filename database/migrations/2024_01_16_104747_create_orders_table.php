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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id'); // TODO@ Change the method to foreign key in actual development
            $table->string('status');
            $table->integer('subtotal');
            $table->integer('tax_rate');
            $table->integer('tax');
            $table->integer('shipping_charge');
            $table->integer('shipping_charge_tax')->nullable();
            $table->integer('total_amount');
            $table->datetime('paid_at');
            $table->string('orderer_name');
            $table->string('orderer_name_kana');
            $table->integer('orderer_prefecture');
            $table->string('orderer_city');
            $table->string('orderer_address');
            $table->string('orderer_tel');
            $table->string('payment_method');
            $table->string('transaction_id')->nullable();
            $table->string('payment_number')->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('shipping_company')->nullable();
            $table->date('order_date');
            $table->date('shipping_date')->nullable();
            $table->string('failure_reason')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
