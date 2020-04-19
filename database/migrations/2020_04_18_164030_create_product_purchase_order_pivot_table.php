<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPurchaseOrderPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_purchase_order', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('purchase_order_id')->unsigned();
            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders');

            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');

            $table->integer('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_purchase_order');
    }
}
