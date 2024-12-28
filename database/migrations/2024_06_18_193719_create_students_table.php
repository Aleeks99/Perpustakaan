<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::dropIfExists('students');
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classroom_id')->references('id')->on('classrooms')->onDelete('cascade');
            $table->string('nisn')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('students', function (Blueprint $table) {
        //     $table->dropForeign(['classroom_id']);
        //     $table->dropIndex(['classroom_id']);
        //     $table->dropColumn('classroom_id');
        // });
        Schema::dropIfExists('students');
    }
};
