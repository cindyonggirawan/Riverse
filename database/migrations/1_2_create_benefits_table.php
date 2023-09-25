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
        Schema::create('benefits', function (Blueprint $table) {
            $table->string('id', 11);

            $table->string('levelId', 11);

            $table->string('name');
            $table->text('description');
            $table->string('couponCode');
            $table->string('bannerImageUrl')->nullable();
            $table->string('slug')->unique();

            $table->timestamps();

            $table->primary('id');

            $table->foreign('levelId')->references('id')->on('levels')->onUpdate('cascade')->onDelete('cascade');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('benefits');
    }
};