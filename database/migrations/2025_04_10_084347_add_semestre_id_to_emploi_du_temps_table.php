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
        // Vérifier si la colonne SemestreID existe déjà dans la table
        if (!Schema::hasColumn('emploi_du_temps', 'SemestreID')) {
            Schema::table('emploi_du_temps', function (Blueprint $table) {
                $table->unsignedBigInteger('SemestreID')->nullable();
            });
        }

        // Ajouter la clé étrangère sans vérifier son existence
        try {
            Schema::table('emploi_du_temps', function (Blueprint $table) {
                $table->foreign('SemestreID')->references('SemestreID')->on('semesters');
            });
        } catch (\Illuminate\Database\QueryException $e) {
            // Ignore the exception if the foreign key already exists
            // Optionally log the error or handle it as needed
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('emploi_du_temps', function (Blueprint $table) {
            // Suppression de la clé étrangère et de la colonne
            $table->dropForeign(['SemestreID']);
            $table->dropColumn('SemestreID');
        });
    }
};
