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
        // Ajouter la colonne NiveauID dans la table semesters
        Schema::table('semesters', function (Blueprint $table) {
            // Ajouter la colonne NiveauID
            $table->unsignedBigInteger('NiveauID');

            // Ajouter la contrainte de clé étrangère
            $table->foreign('NiveauID')->references('NiveauID')->on('niveaux')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Supprimer la clé étrangère et la colonne NiveauID si la migration est annulée
        Schema::table('semesters', function (Blueprint $table) {
            $table->dropForeign(['NiveauID']);
            $table->dropColumn('NiveauID');
        });
    }
};
