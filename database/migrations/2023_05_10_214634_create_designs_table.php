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
        Schema::create('designs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brands_id')->nullable();
            $table->unsignedBigInteger('designner')->nullable();
            $table->longText('textOnPost')->nullable();
            $table->string('status')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('approved_on')->nullable();
            $table->foreign('brands_id')->references('id')->on('users');
            $table->foreign('designner')->references('id')->on('brands');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('designs');
    }
};
