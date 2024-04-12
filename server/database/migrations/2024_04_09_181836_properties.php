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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->text('type');
            $table->boolean('for_rent');
            $table->boolean('for_sale');
            $table->unsignedBigInteger('property_address_id');
            $table->foreign('property_address_id')->references('id')->on('property_addresses');
            $table->unsignedBigInteger('seller_id');
            $table->foreign('seller_id')->references('id')->on('users');
            $table->unsignedBigInteger('application_id');
            $table->foreign('application_id')->references('id')->on('applications');
            $table->decimal('price', 10, 2)->nullable();
            $table->integer('nr_bedrooms');
            $table->integer('nr_bathrooms');
            $table->decimal('square_meters', 10, 2);
            $table->text('description');
            $table->boolean('status');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
