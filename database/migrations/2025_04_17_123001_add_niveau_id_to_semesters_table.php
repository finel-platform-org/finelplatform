<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('semesters', function (Blueprint $table) {
            // Ajouter la colonne (nullable temporairement si la table contient déjà des données)
            $table->unsignedBigInteger('NiveauID')->nullable()->after('Nom');
            
            // Ajouter la contrainte de clé étrangère
            $table->foreign('NiveauID')
                  ->references('NiveauID')
                  ->on('niveaux')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('semesters', function (Blueprint $table) {
            $table->dropForeign(['NiveauID']);
            $table->dropColumn('NiveauID');
        });
    }
};