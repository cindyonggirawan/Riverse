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
        Schema::create('activities', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string("title");
            $table->string("picture");
            $table->string("invitationManager");
            $table->date("registrationDeadline");
            $table->string("status");
            $table->string("rejectionMessage");
            $table->date("date");
            $table->string("startTime");
            $table->string("endTime");
            $table->string("jobName");
            $table->string("jobDescription");
            $table->string("criteria");
            $table->integer("minimumNumberOfSukarelawan");
            $table->string("equipment");
            $table->integer("experiencePointGiven");
            $table->string("groupChatLink");

            $table->foreignId("river_id");
            $table->foreignId("fasilitator_id");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
