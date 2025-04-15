<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropSectionidAndForeignKeyFromGestiondesthemesTable extends Migration
{
    public function up()
    {
        Schema::table('gestiondesthemes', function (Blueprint $table) {
            // Supprimer la contrainte de clé étrangère
            $table->dropForeign(['SectionID']);
            // Supprimer la colonne
            $table->dropColumn('SectionID');
        });
    }

    public function down()
    {
        Schema::table('gestiondesthemes', function (Blueprint $table) {
            // Restaurer la colonne (ajuster le type si nécessaire)
            $table->unsignedBigInteger('SectionID')->nullable();

            // Restaurer la clé étrangère (ajuster le nom de la table de référence si différent)
            $table->foreign('SectionID')->references('SectionID')->on('sections')->onDelete('cascade');
        });
    }
}
