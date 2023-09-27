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
            $table->string('id', 11);

            $table->string('verificationStatusId', 11);
            $table->string('riverId', 11);
            $table->string('fasilitatorId', 11);
            $table->string('activityStatusId', 11);

            $table->string('name');
            $table->text('description');
            $table->date('registrationDeadlineDate');
            $table->date('cleanUpDate');
            $table->time('startTime');
            $table->time('endTime');
            $table->string('gatheringPointUrl');
            $table->string('bannerImageUrl')->nullable();
            $table->string('sukarelawanJobName');
            $table->text('sukarelawanJobDetail');
            $table->text('sukarelawanCriteria');
            $table->bigInteger('minimumNumOfSukarelawan');
            $table->text('sukarelawanEquipment');
            $table->string('groupChatUrl');
            $table->bigInteger('experiencePointGiven')->default(0);
            $table->string('qrCodeImageUrl')->nullable();
            $table->string('slug')->unique();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->string('reasonForRejection')->nullable();

            $table->timestamps();

            $table->primary('id');

            $table->foreign('verificationStatusId')->references('id')->on('verification_statuses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('riverId')->references('id')->on('rivers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('fasilitatorId')->references('id')->on('fasilitators')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('activityStatusId')->references('id')->on('activity_statuses')->onUpdate('cascade')->onDelete('cascade');
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
