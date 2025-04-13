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
    Schema::table('gestiondesthemes', function (Blueprint $table) {
        $table->unsignedBigInteger('DepartementID')->after('ThemeID');

        $table->foreign('DepartmentID')
              ->references('DepartementID')
              ->on('departement')
              ->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('gestiondesthemes', function (Blueprint $table) {
        $table->dropForeign(['DepartmentID']);
        $table->dropColumn('DepartmentID');
    });
}

};
