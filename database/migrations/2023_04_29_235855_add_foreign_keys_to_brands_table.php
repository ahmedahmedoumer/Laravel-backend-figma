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
        Schema::table('brands', function (Blueprint $table) {
            $table->unsignedBigInteger('planners_id')->nullable();
            $table->unsignedBigInteger('designers_id')->nullable();
            $table->foreign('planners_id')->references('id')->on('users')->oDelete('cascade');
            $table->foreign('designers_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            Schema::table('brands',function(Blueprint $table){
                $table->dropColumn('planners_id');
                $table->dropForeign(['planners_id']);
                $table->dropColumn('designers_id');
                $table->dropForeign(['designers_id']);
            });
        });
    }
};
