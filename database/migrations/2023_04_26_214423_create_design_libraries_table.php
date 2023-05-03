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
        Schema::create('design_libraries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('designer_id')->nullable();
            $table->unsignedBigInteger('brands_id')->nullable();
            $table->string('designTitle')->nullable();
            $table->string('image')->nullable();
            $table->string('sourceFile')->nullable();
            $table->string('status')->nullable();
            $table->foreign('designer_id')->references('id')->on('users');
            $table->foreign('brands_id')->references('id')->on('brands');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('design_libraries');
    }
};
