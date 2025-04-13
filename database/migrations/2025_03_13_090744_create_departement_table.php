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
        Schema::create('departement', function (Blueprint $table) {
            $table->id('DepartementID');
            $table->string('Nom', 100)->nullable(false);
            $table->unsignedBigInteger('ChefPedagogiqueID')->nullable();
            $table->timestamps();

            // Ajout de la clé étrangère
            $table->foreign('ChefPedagogiqueID')->references('ProfesseurID')->on('professeurs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('departement', function (Blueprint $table) {
            $table->dropForeign(['ChefPedagogiqueID']);
        });

        Schema::dropIfExists('departement');
    }
};
