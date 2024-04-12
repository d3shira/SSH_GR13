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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('type'); // apartment, house, lokal
            $table->string('owner_name');
            $table->string('document'); // Të përcaktohet data type sipas nevojës (p.sh. VARCHAR)
            $table->boolean('for_rent');
            $table->boolean('for_sale');
            $table->unsignedBigInteger('property_address_id'); // FK për tabelën e adresave të pronave
            $table->foreign('property_address_id')->references('id')->on('property_addresses');
            $table->decimal('price', 10, 2); // Decimal field për çmimin
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->integer('square_meters');
            $table->text('description')->nullable();
            $table->enum('status', ['approved', 'waiting', 'denied']); // Field për të ruajtur statusin
            $table->timestamps(); // Created_at dhe updated_at fields
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
