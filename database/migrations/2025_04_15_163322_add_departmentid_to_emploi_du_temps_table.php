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
        Schema::table('emploi_du_temps', function (Blueprint $table) {
            if (!Schema::hasColumn('emploi_du_temps', 'departement_id')) {
            $table->unsignedBigInteger('departement_id')->after('LocalID');
            $table->foreign('departement_id')->references('DepartementID')->on('departement'); // Make sure table name matches
        }
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emploi_du_temps', function (Blueprint $table) {
            //
        });
    }
};
