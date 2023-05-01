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
            $table->unsignedBigInteger('brands_id');
            $table->string('companyName');
            $table->string('companyWebsite');
            $table->string('companyNumber');
            $table->string('companyDescription');
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
