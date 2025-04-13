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
        Schema::table('modules', function (Blueprint $table) {
            // Check if the foreign key constraint already exists
            // We can't directly check if a foreign key exists in Laravel, but we can check if the column exists
            // Then we proceed to add the foreign key constraint
            if (Schema::hasColumn('module', 'SectionID')) {
                // Add the foreign key if it doesn't already exist
                $table->foreign('SectionID')->references('SectionID')->on('sections')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            // Drop the foreign key and column if they exist
            $table->dropForeign(['SectionID']);
        });
    }
};
