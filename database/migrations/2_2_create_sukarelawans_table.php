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
        Schema::create('sukarelawans', function (Blueprint $table) {
            $table->string('id', 11);

            $table->string('verificationStatusId', 11);
            $table->string('levelId', 11);

            $table->string('gender');
            $table->date('dateOfBirth');
            $table->string('nationalIdentityNumber');
            $table->string('nationalIdentityCardImageUrl')->nullable();
            $table->string('profileImageUrl')->nullable();
            $table->bigInteger('experiencePoint');
            $table->string('slug')->unique();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->string('reasonForRejection')->nullable();

            $table->timestamps();

            $table->primary('id');

            $table->foreign('id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('verificationStatusId')->references('id')->on('verification_statuses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('levelId')->references('id')->on('levels')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sukarelawans');
    }
};
