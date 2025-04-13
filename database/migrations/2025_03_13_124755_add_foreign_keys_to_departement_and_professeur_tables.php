<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_add_foreign_keys_to_departement_and_professeur_tables.php
public function up()
{
    Schema::table('departement', function (Blueprint $table) {
        $table->foreign('ChefPedagogiqueID')->references('ProfesseurID')->on('professeur');
    });

    Schema::table('professeur', function (Blueprint $table) {
        $table->foreign('DepartementID')->references('DepartementID')->on('departement');
    });
}

public function down()
{
    Schema::table('departement', function (Blueprint $table) {
        $table->dropForeign(['ChefPedagogiqueID']);
    });

    Schema::table('professeur', function (Blueprint $table) {
        $table->dropForeign(['DepartementID']);
    });
}
};
