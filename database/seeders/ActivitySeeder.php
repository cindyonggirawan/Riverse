<?php

namespace Database\Seeders;

use App\Models\Activity;
use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Activity::factory()
        ->createMany([
            [
                'title' => 'Activity 1',
                'picture' => asset('/images/placeholder_activitycard.png'),
                'invitationManager' => 'Invitation Manager',
                'registrationDeadline' => Carbon::create(2024, 1, 3),
                'status' => 'UNVERIFIED',
                'rejectionMessage' => '',
                'date' => Carbon::create(2024, 1, 5),
                'startTime' => Carbon::createFromTime(9, 30, 0),
                'endTime' => Carbon::createFromTime(14, 30, 0),
                'jobName' => 'Pembersihan 1',
                'jobDescription' => 'Pembersihan 1 description',
                'criteria' => 'criteria 1',
                'minimumNumberOfSukarelawan' => 5,
                'equipment' => 'equipment 1',
                'experiencePointGiven' => 10,
                'groupChatLink' => 'https://www.instagram.com',
                'river_id' => '1',
                'fasilitator_id' => '1'
            ],
            [
                'title' => 'Activity 2',
                'picture' => asset('/images/placeholder2.jpeg'),
                'invitationManager' => 'Invitation Manager',
                'registrationDeadline' => Carbon::create(2024, 1, 3),
                'status' => 'UNVERIFIED',
                'rejectionMessage' => '',
                'date' => Carbon::create(2024, 1, 5),
                'startTime' => Carbon::createFromTime(9, 30, 0),
                'endTime' => Carbon::createFromTime(14, 30, 0),
                'jobName' => 'Pembersihan 1',
                'jobDescription' => 'Pembersihan 1 description',
                'criteria' => 'criteria 1',
                'minimumNumberOfSukarelawan' => 5,
                'equipment' => 'equipment 1',
                'experiencePointGiven' => 10,
                'groupChatLink' => 'https://www.instagram.com',
                'river_id' => '1',
                'fasilitator_id' => '1'
            ],
            [
                'title' => 'Activity 3',
                'picture' => asset('/images/placeholder_activitycard.png'),
                'invitationManager' => 'Invitation Manager',
                'registrationDeadline' => Carbon::create(2024, 1, 3),
                'status' => 'UNVERIFIED',
                'rejectionMessage' => '',
                'date' => Carbon::create(2024, 1, 5),
                'startTime' => Carbon::createFromTime(9, 30, 0),
                'endTime' => Carbon::createFromTime(14, 30, 0),
                'jobName' => 'Pembersihan 1',
                'jobDescription' => 'Pembersihan 1 description',
                'criteria' => 'criteria 1',
                'minimumNumberOfSukarelawan' => 5,
                'equipment' => 'equipment 1',
                'experiencePointGiven' => 10,
                'groupChatLink' => 'https://www.instagram.com',
                'river_id' => '1',
                'fasilitator_id' => '1'
            ],
            [
                'title' => 'Activity 4',
                'picture' => asset('/images/placeholder2.png'),
                'invitationManager' => 'Invitation Manager',
                'registrationDeadline' => Carbon::create(2024, 1, 3),
                'status' => 'UNVERIFIED',
                'rejectionMessage' => '',
                'date' => Carbon::create(2024, 1, 5),
                'startTime' => Carbon::createFromTime(9, 30, 0),
                'endTime' => Carbon::createFromTime(14, 30, 0),
                'jobName' => 'Pembersihan 1',
                'jobDescription' => 'Pembersihan 1 description',
                'criteria' => 'criteria 1',
                'minimumNumberOfSukarelawan' => 5,
                'equipment' => 'equipment 1',
                'experiencePointGiven' => 10,
                'groupChatLink' => 'https://www.instagram.com',
                'river_id' => '1',
                'fasilitator_id' => '1'
            ],
            [
                'title' => 'Activity 5',
                'picture' => asset('/images/placeholder_activitycard.png'),
                'invitationManager' => 'Invitation Manager',
                'registrationDeadline' => Carbon::create(2024, 1, 3),
                'status' => 'UNVERIFIED',
                'rejectionMessage' => '',
                'date' => Carbon::create(2024, 1, 5),
                'startTime' => Carbon::createFromTime(9, 30, 0),
                'endTime' => Carbon::createFromTime(14, 30, 0),
                'jobName' => 'Pembersihan 1',
                'jobDescription' => 'Pembersihan 1 description',
                'criteria' => 'criteria 1',
                'minimumNumberOfSukarelawan' => 5,
                'equipment' => 'equipment 1',
                'experiencePointGiven' => 10,
                'groupChatLink' => 'https://www.instagram.com',
                'river_id' => '1',
                'fasilitator_id' => '1'
            ],
            [
                'title' => 'Activity 6',
                'picture' => asset('/images/placeholder_activitycard.png'),
                'invitationManager' => 'Invitation Manager',
                'registrationDeadline' => Carbon::create(2024, 1, 3),
                'status' => 'UNVERIFIED',
                'rejectionMessage' => '',
                'date' => Carbon::create(2024, 1, 5),
                'startTime' => Carbon::createFromTime(9, 30, 0),
                'endTime' => Carbon::createFromTime(14, 30, 0),
                'jobName' => 'Pembersihan 1',
                'jobDescription' => 'Pembersihan 1 description',
                'criteria' => 'criteria 1',
                'minimumNumberOfSukarelawan' => 5,
                'equipment' => 'equipment 1',
                'experiencePointGiven' => 10,
                'groupChatLink' => 'https://www.instagram.com',
                'river_id' => '1',
                'fasilitator_id' => '1'
            ],
            [
                'title' => 'Activity 7',
                'picture' => asset('/images/placeholder_activitycard.png'),
                'invitationManager' => 'Invitation Manager',
                'registrationDeadline' => Carbon::create(2024, 1, 3),
                'status' => 'UNVERIFIED',
                'rejectionMessage' => '',
                'date' => Carbon::create(2024, 1, 5),
                'startTime' => Carbon::createFromTime(9, 30, 0),
                'endTime' => Carbon::createFromTime(14, 30, 0),
                'jobName' => 'Pembersihan 1',
                'jobDescription' => 'Pembersihan 1 description',
                'criteria' => 'criteria 1',
                'minimumNumberOfSukarelawan' => 5,
                'equipment' => 'equipment 1',
                'experiencePointGiven' => 10,
                'groupChatLink' => 'https://www.instagram.com',
                'river_id' => '1',
                'fasilitator_id' => '1'
            ],
            [
                'title' => 'Activity 8',
                'picture' => asset('/images/placeholder_activitycard.png'),
                'invitationManager' => 'Invitation Manager',
                'registrationDeadline' => Carbon::create(2024, 1, 3),
                'status' => 'UNVERIFIED',
                'rejectionMessage' => '',
                'date' => Carbon::create(2024, 1, 5),
                'startTime' => Carbon::createFromTime(9, 30, 0),
                'endTime' => Carbon::createFromTime(14, 30, 0),
                'jobName' => 'Pembersihan 1',
                'jobDescription' => 'Pembersihan 1 description',
                'criteria' => 'criteria 1',
                'minimumNumberOfSukarelawan' => 5,
                'equipment' => 'equipment 1',
                'experiencePointGiven' => 10,
                'groupChatLink' => 'https://www.instagram.com',
                'river_id' => '1',
                'fasilitator_id' => '1'
            ],
            [
                'title' => 'Activity 9',
                'picture' => asset('/images/placeholder_activitycard.png'),
                'invitationManager' => 'Invitation Manager',
                'registrationDeadline' => Carbon::create(2024, 1, 3),
                'status' => 'UNVERIFIED',
                'rejectionMessage' => '',
                'date' => Carbon::create(2024, 1, 5),
                'startTime' => Carbon::createFromTime(9, 30, 0),
                'endTime' => Carbon::createFromTime(14, 30, 0),
                'jobName' => 'Pembersihan 1',
                'jobDescription' => 'Pembersihan 1 description',
                'criteria' => 'criteria 1',
                'minimumNumberOfSukarelawan' => 5,
                'equipment' => 'equipment 1',
                'experiencePointGiven' => 10,
                'groupChatLink' => 'https://www.instagram.com',
                'river_id' => '1',
                'fasilitator_id' => '1'
            ],
            [
                'title' => 'Activity 10',
                'picture' => asset('/images/placeholder2.png'),
                'invitationManager' => 'Invitation Manager',
                'registrationDeadline' => Carbon::create(2024, 1, 3),
                'status' => 'UNVERIFIED',
                'rejectionMessage' => '',
                'date' => Carbon::create(2024, 1, 5),
                'startTime' => Carbon::createFromTime(9, 30, 0),
                'endTime' => Carbon::createFromTime(14, 30, 0),
                'jobName' => 'Pembersihan 1',
                'jobDescription' => 'Pembersihan 1 description',
                'criteria' => 'criteria 1',
                'minimumNumberOfSukarelawan' => 5,
                'equipment' => 'equipment 1',
                'experiencePointGiven' => 10,
                'groupChatLink' => 'https://www.instagram.com',
                'river_id' => '1',
                'fasilitator_id' => '1'
            ],
            [
                'title' => 'Activity 11',
                'picture' => asset('/images/placeholder_activitycard.png'),
                'invitationManager' => 'Invitation Manager',
                'registrationDeadline' => Carbon::create(2024, 1, 3),
                'status' => 'UNVERIFIED',
                'rejectionMessage' => '',
                'date' => Carbon::create(2024, 1, 5),
                'startTime' => Carbon::createFromTime(9, 30, 0),
                'endTime' => Carbon::createFromTime(14, 30, 0),
                'jobName' => 'Pembersihan 1',
                'jobDescription' => 'Pembersihan 1 description',
                'criteria' => 'criteria 1',
                'minimumNumberOfSukarelawan' => 5,
                'equipment' => 'equipment 1',
                'experiencePointGiven' => 10,
                'groupChatLink' => 'https://www.instagram.com',
                'river_id' => '1',
                'fasilitator_id' => '1'
            ],
            [
                'title' => 'Activity 12',
                'picture' => asset('/images/placeholder2.png'),
                'invitationManager' => 'Invitation Manager',
                'registrationDeadline' => Carbon::create(2024, 1, 3),
                'status' => 'UNVERIFIED',
                'rejectionMessage' => '',
                'date' => Carbon::create(2024, 1, 5),
                'startTime' => Carbon::createFromTime(9, 30, 0),
                'endTime' => Carbon::createFromTime(14, 30, 0),
                'jobName' => 'Pembersihan 1',
                'jobDescription' => 'Pembersihan 1 description',
                'criteria' => 'criteria 1',
                'minimumNumberOfSukarelawan' => 5,
                'equipment' => 'equipment 1',
                'experiencePointGiven' => 10,
                'groupChatLink' => 'https://www.instagram.com',
                'river_id' => '1',
                'fasilitator_id' => '1'
            ]
        ]);
    }
}