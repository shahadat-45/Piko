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
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();            
            $table->integer('customer_id');
            $table->string('order_id');
            $table->string('ship_fname');
            $table->string('ship_lname')->nullable();
            $table->string('ship_country');
            $table->string('ship_city');
            $table->string('ship_zip')->nullable();
            $table->string('ship_company')->nullable();
            $table->string('ship_email');
            $table->integer('ship_phone');
            $table->string('ship_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
};
