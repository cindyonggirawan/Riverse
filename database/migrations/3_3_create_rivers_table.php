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
        Schema::create('rivers', function (Blueprint $table) {
            $table->string('id', 11);

            $table->string('cityId', 11);

            $table->string('name');
            $table->string('locationUrl');
            $table->string('slug')->unique();

            $table->timestamps();

            $table->primary('id');

            $table->foreign('cityId')->references('id')->on('cities')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rivers');
    }
};
