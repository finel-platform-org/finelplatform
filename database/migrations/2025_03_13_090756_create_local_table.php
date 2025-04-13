<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_local_table.php
public function up()
{
    Schema::create('local', function (Blueprint $table) {
        $table->id('LocalID');
        $table->string('Nom', 100)->nullable(false);
        $table->unsignedBigInteger('GroupID')->nullable();
        $table->foreign('GroupID')->references('GroupID')->on('group');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('local');
    }
};
