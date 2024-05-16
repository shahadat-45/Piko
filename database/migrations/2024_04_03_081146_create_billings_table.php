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
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->string('order_id');
            $table->string('bill_fname');
            $table->string('bill_lname')->nullable();
            $table->string('bill_country');
            $table->string('bill_city');
            $table->string('bill_zip')->nullable();
            $table->string('bill_company')->nullable();
            $table->string('bill_email');
            $table->integer('bill_phone');
            $table->string('bill_address');
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billings');
    }
};
