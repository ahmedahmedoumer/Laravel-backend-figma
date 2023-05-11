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
        Schema::create('brands_companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brands_id')->nullable();
            $table->string('companyName')->nullable();
            $table->string('companyWebsite')->nullable();
            $table->string('companyNumber')->nullable();
            $table->string('companyDescription')->nullable();
            $table->foreign('brands_id')->references('id')->on('brands')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands_companies');
    }
};
