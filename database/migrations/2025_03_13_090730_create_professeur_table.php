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
        Schema::create('professeurs', function (Blueprint $table) {
            $table->id('ProfesseurID');
            $table->string('Nom', 100)->nullable(false);
            $table->unsignedBigInteger('DepartementID')->nullable(); // Foreign key to Departement
            $table->string('grade', 50)->nullable(); // Add grade column
            $table->string('bureau', 50)->nullable(); // Add bureau column
            $table->string('email', 100)->nullable(); // Add email column
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('professeur');
    }
};