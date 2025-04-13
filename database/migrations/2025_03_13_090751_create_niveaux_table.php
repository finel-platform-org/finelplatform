<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_niveau_table.php
public function up()
{
    Schema::create('niveaux', function (Blueprint $table) {
        $table->id('NiveauID');
        $table->string('Nom', 100)->nullable(false);
        $table->unsignedBigInteger('SectionID')->nullable();
        $table->unsignedBigInteger('ParcoursID')->nullable();
        $table->foreign('SectionID')->references('SectionID')->on('section');
        $table->foreign('ParcoursID')->references('ParcoursID')->on('parcours');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('niveau');
    }
};
