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

        $names = ['Level 1', 'Level 2', 'Level 3'];
        foreach ($names as $name) {
            Level::create([
                'id' => Generator::generateId(Level::class),
                'name' => $name,
                'maximumExperiencePoint' => 100,
                'slug' => Generator::generateSlug(Level::class, $name)
            ]);
        }

        $names = ['Benefit 1', 'Benefit 2', 'Benefit 3'];
        foreach ($names as $name) {
            Benefit::create([
                'id' => Generator::generateId(Benefit::class),
                'levelId' => Level::where('name', str_replace('Benefit', 'Level', $name))->first()->id,
                'name' => $name,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'couponCode' => strtoupper(Str::random(10)),
                'slug' => Generator::generateSlug(Benefit::class, $name)
            ]);
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
            'gender' => 'Male',
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
        Sukarelawan::create([
            'id' => $id,
            'verificationStatusId' => VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id,
            'levelId' => Level::where('name', 'Level 1')->first()->id,
            'gender' => $data['gender'],
            'dateOfBirth' => date('Y-m-d', strtotime(str_replace('/', '-', $data['dateOfBirth']))),
            'nationalIdentityNumber' => $data['nationalIdentityNumber'],
            'slug' => $slug
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
            'verificationStatusId' => VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id,
            'fasilitatorTypeId' => $data['fasilitatorTypeId'],
            'description' => $data['description'],
            'address' => $data['address'],
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

        $names = ['Activity 1', 'Activity 2', 'Activity 3'];
        foreach ($names as $name) {
            Activity::create([
                'id' => Generator::generateId(Activity::class),
                'verificationStatusId' => VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id,
                'riverId' => River::where('name', 'Sungai Ciliwung')->first()->id,
                'fasilitatorId' => Fasilitator::first()->id,
                'activityStatusId' => ActivityStatus::where('name', 'Pendaftaran Sedang Dibuka')->first()->id,
                'name' => $name,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'registrationDeadlineDate' => '2023-09-09',
                'cleanUpDate' => '2023-09-10',
                'startTime' => '09:00:00',
                'endTime' => '12:00:00',
                'gatheringPointUrl' => 'https://maps.app.goo.gl/qJZgk1uYFzEmb2ZQ8',
                'sukarelawanJobName' => 'Pembersih Handal',
                'sukarelawanJobDetail' => 'Menangkat sampah di sungai, memisahkan sampah yang dapat didaur ulang, dan membakar sampah yang tidak dapat didaur ulang.',
                'sukarelawanCriteria' => 'Tidak takut air dan kotoran.',
                'minimumNumOfSukarelawan' => 10,
                'sukarelawanEquipment' => 'Plastik sampah besar dan sarung tangan.',
                'groupChatUrl' => 'https://wa.me/8987654321',
                'slug' => Generator::generateSlug(Activity::class, $name)
            ]);
        }
    }
}
