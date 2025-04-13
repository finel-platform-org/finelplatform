<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        

        // Ajouter les colonnes de liaison
        Schema::table('sections', function (Blueprint $table) {
            // Ajouter une colonne `SpecialiteID` nullable
            $table->unsignedBigInteger('SpecialiteID')->nullable()->after('Nom');
            $table->foreign('SpecialiteID')->references('SpecialiteID')->on('specialites')->onDelete('cascade');
            
            // Ajouter une colonne `NiveauID` nullable
            $table->unsignedBigInteger('NiveauID')->nullable()->after('SpecialiteID');
            $table->foreign('NiveauID')->references('NiveauID')->on('niveaux')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Supprimer les colonnes et les clés étrangères de la table `sections`
        Schema::table('sections', function (Blueprint $table) {
            $table->dropForeign(['SpecialiteID']);
            $table->dropForeign(['NiveauID']);
            $table->dropColumn('SpecialiteID');
            $table->dropColumn('NiveauID');
        });

        // Supprimer la table `sections`
        Schema::dropIfExists('sections');
    }
};
