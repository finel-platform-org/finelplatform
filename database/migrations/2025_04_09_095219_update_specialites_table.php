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
        Schema::table('specialites', function (Blueprint $table) {
            // Check if the SectionID column exists and drop its foreign key and column if necessary
            if (Schema::hasColumn('specialites', 'SectionID')) {
                if ($this->checkForeignKeyExists('specialites', 'specialite_sectionid_foreign')) {
                    $table->dropForeign('specialite_sectionid_foreign');
                }
                $table->dropColumn('SectionID');
            }

            // Check if the ParcoursID column exists and drop its foreign key and column if necessary
            if (Schema::hasColumn('specialites', 'ParcoursID')) {
                if ($this->checkForeignKeyExists('specialites', 'specialite_parcoursid_foreign')) {
                    $table->dropForeign('specialite_parcoursid_foreign');
                }
                $table->dropColumn('ParcoursID');
            }

            // Check if the NiveauID column already exists, and if not, add it
            if (!Schema::hasColumn('specialites', 'NiveauID')) {
                $table->unsignedBigInteger('NiveauID')->nullable();
                $table->foreign('NiveauID')->references('NiveauID')->on('niveaux')->onDelete('cascade');
            }

            // Check if the DepartmentID column already exists, and if not, add it
            if (!Schema::hasColumn('specialites', 'DepartmentID')) {
                $table->unsignedBigInteger('DepartmentID')->nullable();
                $table->foreign('DepartmentID')->references('DepartementID')->on('departement')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('specialites', function (Blueprint $table) {
            // Add `SectionID` and `ParcoursID` back if necessary
            $table->unsignedBigInteger('SectionID')->nullable();
            $table->foreign('SectionID')->references('SectionID')->on('sections');

            $table->unsignedBigInteger('ParcoursID')->nullable();
            $table->foreign('ParcoursID')->references('ParcoursID')->on('parcours');

            // Drop the foreign keys for `NiveauID` and `DepartmentID`
            $table->dropForeign(['NiveauID']);
            $table->dropColumn('NiveauID');
            
            $table->dropForeign(['DepartmentID']);
            $table->dropColumn('DepartmentID');
        });
    }

    // Helper function to check if a foreign key exists
    protected function checkForeignKeyExists($table, $keyName)
    {
        $foreignKeys = \DB::select("SHOW CREATE TABLE $table");
        $foreignKeys = $foreignKeys[0]->{'Create Table'};
        return strpos($foreignKeys, $keyName) !== false;
    }
};
