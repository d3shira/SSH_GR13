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
        Schema::table('users', function (Blueprint $table) {
            //

              // Make role_id and ability_id columns nullable
              $table->unsignedBigInteger('role_id')->nullable()->change();
              $table->unsignedBigInteger('ability_id')->nullable()->change();
              
              // Drop the salt column
              $table->dropColumn('salt');
        });
         
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
              // Add back the salt column
              $table->string('salt')->nullable();

              // Revert role_id and ability_id columns to not nullable
              $table->unsignedBigInteger('role_id')->nullable(false)->change();
              $table->unsignedBigInteger('ability_id')->nullable(false)->change();
        });
    }
};
