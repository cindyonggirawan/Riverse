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
        Schema::create('sukarelawan_activity_details', function (Blueprint $table) {
            $table->string('id', 11);
            $table->string("activityId", 11);
            $table->string('sukarelawanId', 11);
            $table->string('sukarelawanActivityStatusId', 11);
            $table->boolean("isLiked");

            $table->primary('id');

            $table->foreign("activityId")->references("id")->on("activities")->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('sukarelawanId')->references("id")->on("sukarelawans")->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('sukarelawanActivityStatusId')->references("id")->on("sukarelawan_activity_statuses")->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
     }

     /**
      * Reverse the migrations.
      */
     public function down(): void
     {
         Schema::dropIfExists('sukarelawan_activity_details');
     }
};
