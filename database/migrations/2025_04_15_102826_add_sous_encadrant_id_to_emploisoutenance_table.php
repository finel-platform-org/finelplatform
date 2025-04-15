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
        Schema::table('emploisoutenance', function (Blueprint $table) {
            // Ajouter la colonne SousEncadrantID (nullable)
            $table->unsignedBigInteger('SousEncadrantID')
                  ->nullable()
                  ->after('ProfesseurID');
            
            // Ajouter la clé étrangère
            $table->foreign('SousEncadrantID')
                  ->references('ProfesseurID')
                  ->on('professeurs')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('emploisoutenance', function (Blueprint $table) {
            // Supprimer la clé étrangère d'abord
            $table->dropForeign(['SousEncadrantID']);
            
            // Puis supprimer la colonne
            $table->dropColumn('SousEncadrantID');
        });
    }
};