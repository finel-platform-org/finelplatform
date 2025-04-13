<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        Schema::table('gestiondesthemes', function (Blueprint $table) {
            // Vérifier si la colonne n'existe pas
            if (!Schema::hasColumn('gestiondesthemes', 'SectionID')) {
                $table->unsignedBigInteger('SectionID')->after('SpecialiteID')->nullable();
            }
        });

        // Vérifier si la clé étrangère n'existe pas avant de l’ajouter
        $fkName = 'gestiondesthemes_sectionid_foreign';
        $exists = DB::select("SELECT CONSTRAINT_NAME 
            FROM information_schema.TABLE_CONSTRAINTS 
            WHERE TABLE_NAME = 'gestiondesthemes' 
            AND CONSTRAINT_NAME = ?", [$fkName]);

        if (empty($exists)) {
            Schema::table('gestiondesthemes', function (Blueprint $table) {
                $table->foreign('SectionID')->references('SectionID')->on('sections')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::table('gestiondesthemes', function (Blueprint $table) {
            // Vérifier si la contrainte existe avant de la supprimer
            if (Schema::hasColumn('gestiondesthemes', 'SectionID')) {
                $table->dropForeign(['SectionID']);
                $table->dropColumn('SectionID');
            }
        });
    }
};
