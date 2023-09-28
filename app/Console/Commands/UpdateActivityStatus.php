<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Activity;
use App\Models\ActivityStatus;
use Illuminate\Console\Command;
use App\Models\VerificationStatus;

class UpdateActivityStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-activity-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $verificationStatusId = VerificationStatus::where('name', 'Sudah Diverifikasi')->first()->id;

        $activities = Activity::where('verificationStatusId', $verificationStatusId)
            ->orderBy('created_at', 'asc')
            ->get();

        $now = Carbon::now();

        $pendaftaranSedangDibukaId = ActivityStatus::where('name', 'Pendaftaran Sedang Dibuka')->first()->id;
        $pendaftaranSudahDitutupId = ActivityStatus::where('name', 'Pendaftaran Sudah Ditutup')->first()->id;
        $aktivitasBelumDimulaiId = ActivityStatus::where('name', 'Aktivitas Belum Dimulai')->first()->id;
        $aktivitasSedangBerlangsungId = ActivityStatus::where('name', 'Aktivitas Sedang Berlangsung')->first()->id;
        $aktivitasSudahSelesaiId = ActivityStatus::where('name', 'Aktivitas Sudah Selesai')->first()->id;

        foreach ($activities as $activity) {
            $activityStatusId = $activity->activityStatusId;

            $registrationDeadlineDate = Carbon::parse($activity->registrationDeadlineDate);
            $cleanUpDate = Carbon::parse($activity->cleanUpDate);
            $cleanUpDate_ = Carbon::parse($activity->cleanUpDate);
            $cleanUpDate__ = Carbon::parse($activity->cleanUpDate);

            $startTime_ = Carbon::parse($activity->startTime);
            $startTime = $cleanUpDate_->setTime($startTime_->hour, $startTime_->minute, $startTime_->second);

            $endTime__ = Carbon::parse($activity->endTime);
            $endTime = $cleanUpDate__->setTime($endTime__->hour, $endTime__->minute, $endTime__->second);

            if ($now >= $endTime && $now >= $startTime && $now >= $cleanUpDate && $now >= $registrationDeadlineDate) {
                $activityStatusId = $aktivitasSudahSelesaiId;
            } else if ($now < $endTime && $now >= $startTime && $now >= $cleanUpDate && $now >= $registrationDeadlineDate) {
                $activityStatusId = $aktivitasSedangBerlangsungId;
            } else if ($now < $endTime && $now < $startTime && $now >= $cleanUpDate && $now >= $registrationDeadlineDate) {
                $activityStatusId = $aktivitasBelumDimulaiId;
            } else if ($now < $endTime && $now < $startTime && $now < $cleanUpDate && $now >= $registrationDeadlineDate) {
                $activityStatusId = $pendaftaranSudahDitutupId;
            } else if ($now < $endTime && $now < $startTime && $now < $cleanUpDate && $now < $registrationDeadlineDate) {
                $activityStatusId = $pendaftaranSedangDibukaId;
            }

            $activity->update([
                'activityStatusId' => $activityStatusId
            ]);
        }

        $this->info('Activity statuses updated successfully.');
    }
}
