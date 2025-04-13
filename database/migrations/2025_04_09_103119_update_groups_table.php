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
        Schema::table('groups', function (Blueprint $table) {
            // Supprimer la colonne 'SpecialiteID' si elle existe
            if (Schema::hasColumn('groups', 'SpecialiteID')) {
                $table->dropForeign('group_specialiteid_foreign'); // Supprimer la clé étrangère
                $table->dropColumn('SpecialiteID'); // Supprimer la colonne
            }

            // Ajouter la colonne 'SectionID' pour lier le groupe à une section
            if (!Schema::hasColumn('groups', 'SectionID')) {
                $table->unsignedBigInteger('SectionID')->nullable();
                $table->foreign('SectionID')->references('SectionID')->on('sections')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('groups', function (Blueprint $table) {
            // Supprimer la clé étrangère et la colonne 'SectionID'
            $table->dropForeign(['SectionID']);
            $table->dropColumn('SectionID');

            // Ajouter à nouveau 'SpecialiteID' si nécessaire
            $table->unsignedBigInteger('SpecialiteID')->nullable();
            $table->foreign('SpecialiteID')->references('SpecialiteID')->on('specialites')->onDelete('cascade');
        });
    }
};
