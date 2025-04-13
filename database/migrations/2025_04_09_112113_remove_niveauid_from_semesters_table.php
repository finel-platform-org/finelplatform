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
        Schema::table('semesters', function (Blueprint $table) {
            // Drop the foreign key constraint if it exists
            $table->dropForeign(['NiveauID']);

            // Drop the NiveauID column
            $table->dropColumn('NiveauID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('semesters', function (Blueprint $table) {
            // Add the NiveauID column back
            $table->unsignedBigInteger('NiveauID')->nullable();

            // Optionally, add the foreign key back
            $table->foreign('NiveauID')->references('NiveauID')->on('niveaux')->onDelete('cascade');
        });
    }
};
