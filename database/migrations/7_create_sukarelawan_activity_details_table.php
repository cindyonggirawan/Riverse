<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // /**
    //  * Run the migrations.
    //  */
    // public function up(): void
    // {
    //     Schema::create('sukarelawan_activity_details', function (Blueprint $table) {
    //         $table->id()->autoIncrement();
    //         $table->string("status");
    //         $table->boolean("isLiked");

    //         $table->foreignId("activity_id");
    //         $table->foreignId("sukarelawan_id");

    //         // $table->foreign("activityId")->references("id")->on("activities");
    //         // $table->foreign("sukarelawanId")->references("id")->on("sukarelawans");
    //         $table->timestamps();
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  */
    // public function down(): void
    // {
    //     Schema::dropIfExists('sukarelawan_activity_details');
    // }
};
