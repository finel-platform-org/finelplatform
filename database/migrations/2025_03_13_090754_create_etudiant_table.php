<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_xx_xx_create_etudiant_table.php
public function up()
{
    Schema::create('etudiant', function (Blueprint $table) {
        $table->id('EtudiantID');
        $table->string('Nom', 100)->nullable(false);
        $table->unsignedBigInteger('GroupID')->nullable();
        $table->unsignedBigInteger('SpecialiteID')->nullable();
        $table->unsignedBigInteger('NiveauID')->nullable();
        $table->foreign('GroupID')->references('GroupID')->on('group');
        $table->foreign('SpecialiteID')->references('SpecialiteID')->on('specialite');
        $table->foreign('NiveauID')->references('NiveauID')->on('niveau');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etudiant');
    }
};
