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
         Schema::create('experience_histories', function (Blueprint $table) {
            $table->string('id', 11);
            $table->integer("acquiredExp");
            $table->string('sukarelawanId', 11);
            $table->string('fasilitatorId', 11);

            $table->primary('id');

            $table->foreign('sukarelawanId')->references('id')->on('sukarelawans')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('fasilitatorId')->references('id')->on('fasilitators')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
         });
     }

     /**
      * Reverse the migrations.
      */
     public function down(): void
     {
         Schema::dropIfExists('experience_histories');
     }
};
