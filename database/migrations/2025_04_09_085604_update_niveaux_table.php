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
        Schema::table('niveaux', function (Blueprint $table) {
            // Drop the foreign key constraint
            if (Schema::hasColumn('niveaux', 'SectionID')) {
                $table->dropForeign('niveau_sectionid_foreign');  // Drop the foreign key constraint
                $table->dropColumn('SectionID');  // Drop the SectionID column
            }

            // Add new columns or modify existing ones as needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('niveaux', function (Blueprint $table) {
            // If you need to restore the dropped column and foreign key
            $table->unsignedBigInteger('SectionID')->nullable();
            $table->foreign('SectionID')->references('SectionID')->on('sections');
        });
    }
};
