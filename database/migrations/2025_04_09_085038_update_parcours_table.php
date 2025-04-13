<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('parcours', function (Blueprint $table) {
            // Supprimer la clé étrangère et la colonne SectionID si elle existe
            if (Schema::hasColumn('parcours', 'SectionID')) {
                $table->dropForeign(['SectionID']);
                $table->dropColumn('SectionID');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parcours', function (Blueprint $table) {
            // Réajouter SectionID en cas de rollback (non nécessaire si plus utilisé)
            $table->unsignedBigInteger('SectionID')->nullable();
            $table->foreign('SectionID')->references('SectionID')->on('sections')->onDelete('set null');
        });
    }
};
