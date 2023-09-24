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
        Schema::create('users', function (Blueprint $table) {
            $table->string('id', 11);

            $table->string('roleId', 11);

            $table->string('email')->unique();
            $table->string('password');
            $table->string('name');
            $table->string('slug')->unique();

            $table->timestamps();

            $table->primary('id');

            $table->foreign('roleId')->references('id')->on('roles')->onUpdate('cascade')->onDelete('cascade');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
