<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_xx_xx_create_group_table.php
public function up()
{
    Schema::create('groups', function (Blueprint $table) {
        $table->id('GroupID');
        $table->string('Nom', 100)->nullable(false);
        $table->unsignedBigInteger('SpecialiteID')->nullable();
        $table->foreign('SpecialiteID')->references('SpecialiteID')->on('specialite');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group');
    }
};
