<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // 1. Ajouter la colonne si elle n'existe pas
        if (!Schema::hasColumn('niveaux', 'departement_id')) {
            Schema::table('niveaux', function (Blueprint $table) {
                $table->unsignedBigInteger('departement_id')->nullable();
            });
        }

        // 2. Peupler avec une valeur par défaut
        if (Schema::hasTable('departement')) {
            $defaultDept = DB::table('departement')->first();
            if ($defaultDept) {
                DB::table('niveaux')->update(['departement_id' => $defaultDept->DepartementID]);
            }
        }

        // 3. Supprimer l'ancienne contrainte si elle existe
        $constraintName = 'niveaux_departement_id_foreign';
        try {
            DB::statement("ALTER TABLE niveaux DROP FOREIGN KEY {$constraintName}");
        } catch (\Exception $e) {
            // Ignorer si la contrainte n'existe pas
        }

        // 4. Ajouter la nouvelle contrainte en CASCADE
        DB::statement("
            ALTER TABLE niveaux 
            ADD CONSTRAINT {$constraintName} 
            FOREIGN KEY (departement_id) 
            REFERENCES departement(DepartementID) 
            ON DELETE CASCADE");

        // 5. Rendre la colonne obligatoire
        DB::statement("ALTER TABLE niveaux MODIFY departement_id BIGINT UNSIGNED NOT NULL");
    }

    public function down()
    {
        Schema::table('niveaux', function (Blueprint $table) {
            $constraintName = 'niveaux_departement_id_foreign';
            try {
                DB::statement("ALTER TABLE niveaux DROP FOREIGN KEY {$constraintName}");
            } catch (\Exception $e) {
                // Ignorer si la contrainte n'existe pas
            }
            
            if (Schema::hasColumn('niveaux', 'departement_id')) {
                $table->dropColumn('departement_id');
            }
        });
    }
};