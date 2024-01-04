<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Activity;
use App\Models\Role;
use App\Models\User;
use App\Models\Level;
use App\Models\Benefit;
use App\Models\Generator;
use Illuminate\Support\Str;
use App\Models\ActivityStatus;
use App\Models\FasilitatorType;
use Illuminate\Database\Seeder;
use App\Models\VerificationStatus;
use Illuminate\Support\Facades\Hash;
use App\Models\Fasilitator;
use App\Models\River;
use App\Models\Sukarelawan;
use App\Models\SukarelawanActivityDetail;
use App\Models\SukarelawanActivityStatus;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $names = ['Admin', 'Sukarelawan', 'Fasilitator'];
        foreach ($names as $name) {
            Role::create([
                'id' => Generator::generateId(Role::class),
                'name' => $name,
                'slug' => Generator::generateSlug(Role::class, $name)
            ]);
        }

        $names = ['Yayasan', 'Koperasi', 'Perusahaan', 'Umum', 'Komunitas', 'Lembaga Pemerintah', 'Perkumpulan', 'Lain-lain'];
        foreach ($names as $name) {
            FasilitatorType::create([
                'id' => Generator::generateId(FasilitatorType::class),
                'name' => $name,
                'slug' => Generator::generateSlug(FasilitatorType::class, $name)
            ]);
        }

        $names = ['Menunggu Verifikasi', 'Sudah Diverifikasi', 'Sudah Ditolak'];
        foreach ($names as $name) {
            VerificationStatus::create([
                'id' => Generator::generateId(VerificationStatus::class),
                'name' => $name,
                'slug' => Generator::generateSlug(VerificationStatus::class, $name)
            ]);
        }

        $names = ['Pendaftaran Sedang Dibuka', 'Pendaftaran Sudah Ditutup', 'Aktivitas Belum Dimulai', 'Aktivitas Sedang Berlangsung', 'Aktivitas Sudah Selesai'];
        foreach ($names as $name) {
            ActivityStatus::create([
                'id' => Generator::generateId(ActivityStatus::class),
                'name' => $name,
                'slug' => Generator::generateSlug(ActivityStatus::class, $name)
            ]);
        }

        $names = ['Null', 'Joined', 'ClockedIn', 'Claimed'];
        foreach ($names as $name) {
            SukarelawanActivityStatus::create([
                'id' => Generator::generateId(SukarelawanActivityStatus::class),
                'name' => $name,
                'slug' => Generator::generateSlug(SukarelawanActivityStatus::class, $name)
            ]);
        }

        Level::create([
            'id' => Generator::generateId(Level::class),
            'name' => 'Level 1',
            'maximumExperiencePoint' => 100,
            'slug' => Generator::generateSlug(Level::class, 'Level 1')
        ]);

        Level::create([
            'id' => Generator::generateId(Level::class),
            'name' => 'Level 2',
            'maximumExperiencePoint' => 200,
            'slug' => Generator::generateSlug(Level::class, 'Level 2')
        ]);

        Level::create([
            'id' => Generator::generateId(Level::class),
            'name' => 'Level 3',
            'maximumExperiencePoint' => 300,
            'slug' => Generator::generateSlug(Level::class, 'Level 3')
        ]);

        Level::create([
            'id' => Generator::generateId(Level::class),
            'name' => 'Level 4',
            'maximumExperiencePoint' => 400,
            'slug' => Generator::generateSlug(Level::class, 'Level 4')
        ]);

        Level::create([
            'id' => Generator::generateId(Level::class),
            'name' => 'Level 5',
            'maximumExperiencePoint' => 500,
            'slug' => Generator::generateSlug(Level::class, 'Level 5')
        ]);

        Level::create([
            'id' => Generator::generateId(Level::class),
            'name' => 'Level 6',
            'maximumExperiencePoint' => 600,
            'slug' => Generator::generateSlug(Level::class, 'Level 6')
        ]);

        $names = [
            "Voucher B2G1 Kopi XYZ",
            "Voucher BOGO Kopi XYZ",
            'Totebag dari XYZ',
            'Kopi Gratis di Kopi XYZ',
            "Riverse Limited Edition Tee",
            'Tumbler dari Riverse',
            '2 Kopi Gratis di Kopi XYZ',
            "3 Voucher BOGO Kopi XYZ",
        ];

        $benefitCounter = 1;

        foreach ($names as $name) {
            Benefit::create([
                'id' => Generator::generateId(Benefit::class),
                'levelId' => Level::where('name', "Level " . $benefitCounter)->first()->id,
                'name' => $name,
                'description' => 'Redeem voucher yang kamu dapatkan di Toko XYZ terdekat.',
                'couponCode' => strtoupper(Str::random(10)),
                'slug' => Generator::generateSlug(Benefit::class, $name)
            ]);
            $benefitCounter++;
            if ($benefitCounter >= 6) {
                $benefitCounter = 6;
            }
        }

        /* OPEN USER */

        $email = 'admin@riverse.com';
        $password = 'Admin123';
        $name = 'Admin';
        $id = str_replace('UR', 'AN', Generator::generateId(User::class));
        $slug = Generator::generateSlug(User::class, $name);
        User::create([
            'id' => $id,
            'roleId' => Role::where('name', 'Admin')->first()->id,
            'email' => $email,
            'password' => Hash::make($password),
            'name' => $name,
            'slug' => $slug
        ]);

        $data = [
            'email' => 'sukarelawan@riverse.com',
            'password' => 'Sukarelawan123',
            'name' => 'Sukarelawan',
            'gender' => 'Laki-laki',
            'dateOfBirth' => '01/01/2001',
            'nationalIdentityNumber' => '0000000000000001'
        ];
        $id = Generator::generateId(Sukarelawan::class);
        $slug = Generator::generateSlug(User::class, $data['name']);
        User::create([
            'id' => $id,
            'roleId' => Role::where('name', 'Sukarelawan')->first()->id,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'name' => $data['name'],
            'slug' => $slug
        ]);
        User::create([
            'id' => "1",
            'roleId' => Role::where('name', 'Sukarelawan')->first()->id,
            'email' => 'sukarelawan1@riverse.com',
            'password' => Hash::make($data['password']),
            'name' => 'Sukarelawan Leaderboard 1',
            'slug' => Generator::generateSlug(User::class, 'Sukarelawan Leaderboard 1')
        ]);
        User::create([
            'id' => "2",
            'roleId' => Role::where('name', 'Sukarelawan')->first()->id,
            'email' => 'sukarelawan2@riverse.com',
            'password' => Hash::make($data['password']),
            'name' => 'Sukarelawan Leaderboard 2',
            'slug' => Generator::generateSlug(User::class, 'Sukarelawan Leaderboard 2')
        ]);
        User::create([
            'id' => "3",
            'roleId' => Role::where('name', 'Sukarelawan')->first()->id,
            'email' => 'sukarelawan3@riverse.com',
            'password' => Hash::make($data['password']),
            'name' => 'Sukarelawan Leaderboard 3',
            'slug' => Generator::generateSlug(User::class, 'Sukarelawan Leaderboard 3')
        ]);
        User::create([
            'id' => "4",
            'roleId' => Role::where('name', 'Sukarelawan')->first()->id,
            'email' => 'sukarelawan4@riverse.com',
            'password' => Hash::make($data['password']),
            'name' => 'Sukarelawan Leaderboard 4',
            'slug' => Generator::generateSlug(User::class, 'Sukarelawan Leaderboard 4')
        ]);
        User::create([
            'id' => "5",
            'roleId' => Role::where('name', 'Sukarelawan')->first()->id,
            'email' => 'sukarelawan5@riverse.com',
            'password' => Hash::make($data['password']),
            'name' => 'Sukarelawan Leaderboard 5',
            'slug' => Generator::generateSlug(User::class, 'Sukarelawan Leaderboard 5')
        ]);



        Sukarelawan::create([
            'id' => $id,
            'verificationStatusId' => VerificationStatus::where('name', 'Sudah Diverifikasi')->first()->id,
            'levelId' => Level::where('name', 'Level 1')->first()->id,
            'gender' => $data['gender'],
            'verified_at' => now(),
            'dateOfBirth' => date('Y-m-d', strtotime(str_replace('/', '-', $data['dateOfBirth']))),
            'nationalIdentityNumber' => $data['nationalIdentityNumber'],
            'slug' => $slug
        ]);
        Sukarelawan::create([
            'id' => '1',
            'verificationStatusId' => VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id,
            'levelId' => Level::where('name', 'Level 1')->first()->id,
            'gender' => $data['gender'],
            'dateOfBirth' => date('Y-m-d', strtotime(str_replace('/', '-', $data['dateOfBirth']))),
            'nationalIdentityNumber' => '0000000000000002',
            'slug' => Generator::generateSlug(User::class, 'Sukarelawan Leaderboard 1')
        ]);
        Sukarelawan::create([
            'id' => '2',
            'verificationStatusId' => VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id,
            'levelId' => Level::where('name', 'Level 1')->first()->id,
            'gender' => $data['gender'],
            'dateOfBirth' => date('Y-m-d', strtotime(str_replace('/', '-', $data['dateOfBirth']))),
            'nationalIdentityNumber' => '0000000000000003',
            'slug' => Generator::generateSlug(User::class, 'Sukarelawan Leaderboard 2')
        ]);
        Sukarelawan::create([
            'id' => '3',
            'verificationStatusId' => VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id,
            'levelId' => Level::where('name', 'Level 1')->first()->id,
            'gender' => $data['gender'],
            'dateOfBirth' => date('Y-m-d', strtotime(str_replace('/', '-', $data['dateOfBirth']))),
            'nationalIdentityNumber' => '0000000000000004',
            'slug' => Generator::generateSlug(User::class, 'Sukarelawan Leaderboard 3')
        ]);
        Sukarelawan::create([
            'id' => '4',
            'verificationStatusId' => VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id,
            'levelId' => Level::where('name', 'Level 1')->first()->id,
            'gender' => $data['gender'],
            'dateOfBirth' => date('Y-m-d', strtotime(str_replace('/', '-', $data['dateOfBirth']))),
            'nationalIdentityNumber' => '0000000000000005',
            'slug' => Generator::generateSlug(User::class, 'Sukarelawan Leaderboard 4')
        ]);
        Sukarelawan::create([
            'id' => '5',
            'verificationStatusId' => VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id,
            'levelId' => Level::where('name', 'Level 1')->first()->id,
            'gender' => $data['gender'],
            'dateOfBirth' => date('Y-m-d', strtotime(str_replace('/', '-', $data['dateOfBirth']))),
            'nationalIdentityNumber' => '0000000000000006',
            'slug' => Generator::generateSlug(User::class, 'Sukarelawan Leaderboard 5')
        ]);

        $data = [
            'email' => 'fasilitator@riverse.com',
            'password' => 'Fasilitator123',
            'name' => 'Fasilitator',
            'fasilitatorTypeId' => FasilitatorType::where('name', 'Komunitas')->first()->id,
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'address' => 'Jl. Pondok Indah No. 123, Kota Jakarta Utara',
            'phoneNumber' => '8987654321'
        ];
        $id = Generator::generateId(Fasilitator::class);
        $slug = Generator::generateSlug(User::class, $data['name']);
        User::create([
            'id' => $id,
            'roleId' => Role::where('name', 'Fasilitator')->first()->id,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'name' => $data['name'],
            'slug' => $slug
        ]);
        Fasilitator::create([
            'id' => $id,
            'verificationStatusId' => VerificationStatus::where('name', 'Sudah Diverifikasi')->first()->id,
            'fasilitatorTypeId' => $data['fasilitatorTypeId'],
            'description' => $data['description'],
            'address' => $data['address'],
            'verified_at' => now(),
            'phoneNumber' => $data['phoneNumber'],
            'slug' => $slug
        ]);

        /* CLOSE USER */

        $name = 'Sungai Ciliwung';
        River::create([
            'id' => Generator::generateId(River::class),
            'name' => $name,
            'locationUrl' => 'https://maps.app.goo.gl/qJZgk1uYFzEmb2ZQ8',
            'slug' => Generator::generateSlug(River::class, $name)
        ]);

        $names = ['Activity 1', 'Activity 2', 'Activity 3', 'Activity 4', 'Activity 5', 'Activity 6', 'Activity 7', 'Activity 8', 'Activity 9', 'Activity 10', 'Activity 11'];
        foreach ($names as $name) {
            Activity::create([
                'id' => Generator::generateId(Activity::class),
                'verificationStatusId' => VerificationStatus::where('name', 'Sudah Diverifikasi')->first()->id,
                'riverId' => River::where('name', 'Sungai Ciliwung')->first()->id,
                'fasilitatorId' => Fasilitator::first()->id,
                'activityStatusId' => ActivityStatus::where('name', 'Pendaftaran Sedang Dibuka')->first()->id,
                'name' => $name,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'registrationDeadlineDate' => '2024-7-7',
                'experiencePointGiven' => 20,
                'cleanUpDate' => '2024-8-8',
                'startTime' => '13:00:00',
                'endTime' => '16:00:00',
                'gatheringPointUrl' => 'https://maps.app.goo.gl/qJZgk1uYFzEmb2ZQ8',
                'sukarelawanJobName' => 'Pembersih Handal',
                'sukarelawanJobDetail' => 'Menangkat sampah di sungai, memisahkan sampah yang dapat didaur ulang, dan membakar sampah yang tidak dapat didaur ulang.',
                'sukarelawanCriteria' => 'Tidak takut air dan kotoran.',
                'verified_at' => now(),
                'minimumNumOfSukarelawan' => 10,
                'sukarelawanEquipment' => 'Plastik sampah besar dan sarung tangan.',
                'groupChatUrl' => 'https://wa.me/8987654321',
                'slug' => Generator::generateSlug(Activity::class, $name)
            ]);
        }

        //fill the activity details for sukarelawan 1
        $activities = Activity::all();
        foreach ($activities as $activity) {
            SukarelawanActivityDetail::create([
                'id' => Generator::generateId(Activity::class),
                'activityId' => $activity->id,
                'sukarelawanActivityStatusId' => SukarelawanActivityStatus::where('name', 'Joined')->first()->id,
                'sukarelawanId' => "1",
                'isLiked' => false
            ]);
        }

        //fill the activity details for sukarelawan 2
        SukarelawanActivityDetail::create([
            'id' => Generator::generateId(SukarelawanActivityDetail::class),
            'activityId' => $activities[0]->id,
            'sukarelawanId' => "2",
            'sukarelawanActivityStatusId' => SukarelawanActivityStatus::where('name', 'Joined')->first()->id,
            'isLiked' => false
        ]);
        SukarelawanActivityDetail::create([
            'id' => Generator::generateId(SukarelawanActivityDetail::class),
            'activityId' => $activities[1]->id,
            'sukarelawanId' => "2",
            'sukarelawanActivityStatusId' => SukarelawanActivityStatus::where('name', 'Joined')->first()->id,
            'isLiked' => false
        ]);

        //fill the activity details for sukarelawan 3
        SukarelawanActivityDetail::create([
            'id' => Generator::generateId(SukarelawanActivityDetail::class),
            'activityId' => $activities[0]->id,
            'sukarelawanId' => "3",
            'sukarelawanActivityStatusId' => SukarelawanActivityStatus::where('name', 'Joined')->first()->id,
            'isLiked' => false
        ]);
        SukarelawanActivityDetail::create([
            'id' => Generator::generateId(SukarelawanActivityDetail::class),
            'activityId' => $activities[2]->id,
            'sukarelawanId' => "3",
            'sukarelawanActivityStatusId' => SukarelawanActivityStatus::where('name', 'Joined')->first()->id,
            'isLiked' => false
        ]);

        //fill the activity details for sukarelawan 4
        SukarelawanActivityDetail::create([
            'id' => Generator::generateId(SukarelawanActivityDetail::class),
            'activityId' => $activities[1]->id,
            'sukarelawanId' => "4",
            'sukarelawanActivityStatusId' => SukarelawanActivityStatus::where('name', 'Joined')->first()->id,
            'isLiked' => false
        ]);
        SukarelawanActivityDetail::create([
            'id' => Generator::generateId(SukarelawanActivityDetail::class),
            'activityId' => $activities[2]->id,
            'sukarelawanId' => "4",
            'sukarelawanActivityStatusId' => SukarelawanActivityStatus::where('name', 'Joined')->first()->id,
            'isLiked' => false
        ]);
    }
}
