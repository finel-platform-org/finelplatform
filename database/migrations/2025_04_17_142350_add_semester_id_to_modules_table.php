<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->unsignedBigInteger('SemesterID')->nullable()->after('SectionID');
            
            $table->foreign('SemesterID')
                  ->references('SemestreID')
                  ->on('semesters')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropForeign(['SemesterID']);
            $table->dropColumn('SemesterID');
        });
    }
};