<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('gestion_theme_professeur', function (Blueprint $table) {
            // Ajouter un champ "role" (ex : encadrant, sous-encadrant)
            $table->string('role')->default('encadrant')->after('ProfesseurID');
        });
    }

    public function down()
    {
        Schema::table('gestion_theme_professeur', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
