<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('activites', function (Blueprint $table) {
            // 1. Disable foreign key checks (MySQL specific)
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            
            // 2. Drop the foreign keys using their exact names
            $table->dropForeign('activite_moduleid_foreign');
            $table->dropForeign('activite_professeurid_foreign');
            
            // 3. Drop the columns
            $table->dropColumn(['ModuleID', 'ProfesseurID']);
            
            // 4. Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        });
    }

    public function down()
    {
        Schema::table('activites', function (Blueprint $table) {
            // 1. Add the columns back (nullable first)
            $table->unsignedBigInteger('ModuleID')->nullable();
            $table->unsignedBigInteger('ProfesseurID')->nullable();
            
            // 2. Recreate the foreign keys with their original names
            $table->foreign('ModuleID', 'activite_moduleid_foreign')
                  ->references('ModuleID')->on('modules');
                  
            $table->foreign('ProfesseurID', 'activite_professeurid_foreign')
                  ->references('ProfesseurID')->on('professeurs');
        });
    }
};