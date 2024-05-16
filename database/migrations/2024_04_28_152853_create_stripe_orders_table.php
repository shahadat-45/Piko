<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stripe_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            //orders
            $table->integer('discount')->nullable();
            $table->integer('charge');
            $table->integer('total');
            //billings
            $table->string('bill_fname');
            $table->string('bill_lname')->nullable();
            $table->string('bill_country');
            $table->string('bill_city');
            $table->string('bill_zip')->nullable();
            $table->string('bill_company')->nullable();
            $table->string('bill_email');
            $table->integer('bill_phone');
            $table->string('bill_address')->nullable();
            $table->string('notes')->nullable();
            //shipping
            $table->string('ship_fname')->nullable();
            $table->string('ship_lname')->nullable();
            $table->string('ship_country')->nullable();
            $table->string('ship_city')->nullable();
            $table->string('ship_zip')->nullable();
            $table->string('ship_company')->nullable();
            $table->string('ship_email')->nullable();
            $table->integer('ship_phone')->nullable();
            $table->string('ship_address')->nullable();
            //order_product
            $table->integer('checkbox')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stripe_orders');
    }
};
