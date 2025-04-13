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
        Schema::table('locals', function (Blueprint $table) {
            $table->integer('Capacite')->nullable()->after('Nom');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('locals', function (Blueprint $table) {
        $table->dropColumn('Capacite');
    });
}

};
