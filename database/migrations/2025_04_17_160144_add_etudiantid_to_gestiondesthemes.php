<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('gestiondesthemes', function (Blueprint $table) {
            // Ajouter la colonne EtudiantID
            $table->unsignedBigInteger('EtudiantID')->after('DepartementID');
            
            // Définir la clé étrangère
            $table->foreign('EtudiantID')
                  ->references('EtudiantID')
                  ->on('etudiants')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('gestiondesthemes', function (Blueprint $table) {
            // Supprimer la contrainte de clé étrangère
            $table->dropForeign(['EtudiantID']);
            
            // Supprimer la colonne
            $table->dropColumn('EtudiantID');
        });
    }
};