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
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->integer('num_bedrooms')->nullable();
            $table->integer('num_bathrooms')->nullable();
            $table->decimal('square_meters', 10, 2)->nullable();
            $table->integer('floor_number')->nullable();
            $table->boolean('has_balcony')->nullable();
            $table->boolean('has_garden')->nullable();
            $table->boolean('has_garage')->nullable();
            $table->boolean('has_parking')->nullable();
            $table->boolean('has_elevator')->nullable();
            $table->string('local_type')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('features');
    }
};
