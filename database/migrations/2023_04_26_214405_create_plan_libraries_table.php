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
        Schema::create('plan_libraries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('planner_id')->nullable();
            $table->unsignedBigInteger('brands_id')->nullable();
            $table->string('planTitle')->nullable();
            $table->string('planDescription')->nullable();
            $table->string('planPrompt')->nullable();
            $table->string('sourceFile')->nullable();
            $table->string('status')->nullable();
            $table->string('approved_by')->nullable();
            $table->dateTime('approved_on')->nullable();
            $table->foreign('planner_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('brands_id')->references('id')->on('brands')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_libraries');
    }
};
