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
        Schema::table('departement', function (Blueprint $table) {
            // Ajout de la clé étrangère
            $table->unsignedBigInteger('ChefPedagogiqueID')->nullable()->after('nom');
            $table->foreign('ChefPedagogiqueID')
                  ->references('ProfesseurID')->on('professeurs')
                  ->onDelete('set null'); // Si le professeur est supprimé, met à NULL
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
    }
};
