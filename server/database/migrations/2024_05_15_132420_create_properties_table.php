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
            $table->unsignedBigInteger('property_type_id');
            $table->unsignedBigInteger('address_id');
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('property_feature_id');
            $table->text('description')->nullable();
            $table->date('date_listed')->nullable();
            $table->boolean('for_rent')->default(false);
            $table->boolean('for_sale')->default(false);
            $table->string('status')->nullable();
            $table->timestamps();

            $table->foreign('property_type_id')->references('id')->on('property_types')->onDelete('cascade');
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('sales_agents')->onDelete('cascade');
            $table->foreign('owner_id')->references('id')->on('owners')->onDelete('cascade');
            $table->foreign('property_feature_id')->references('id')->on('features')->onDelete('cascade');
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
