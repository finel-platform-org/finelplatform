<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('themes', function (Blueprint $table) {
            // Check if column doesn't exist before adding it
            if (!Schema::hasColumn('themes', 'DepartementID')) {
                $table->unsignedBigInteger('DepartementID')->after('ProfesseurID');
                
                // Add foreign key constraint
                $table->foreign('DepartementID')
                      ->references('DepartementID')
                      ->on('departement')
                      ->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('themes', function (Blueprint $table) {
            // Only drop if column exists
            if (Schema::hasColumn('themes', 'DepartementID')) {
                $table->dropForeign(['DepartementID']);
                $table->dropColumn('DepartementID');
            }
        });
    }
};