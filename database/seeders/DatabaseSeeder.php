<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\User;
use App\Models\Level;
use App\Models\Benefit;
use App\Models\Generator;
use Illuminate\Support\Str;
use App\Models\ActivityStatus;
use App\Models\City;
use App\Models\FasilitatorType;
use Illuminate\Database\Seeder;
use App\Models\SukarelawanStatus;
use App\Models\VerificationStatus;
use Illuminate\Support\Facades\Hash;
use App\Models\ExperiencePointStatus;
use App\Models\River;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

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

        $names = ['Sedang Dibuka', 'Sudah Ditutup', 'Sedang Berlangsung', 'Sudah Selesai'];
        foreach ($names as $name) {
            ActivityStatus::create([
                'id' => Generator::generateId(ActivityStatus::class),
                'name' => $name,
                'slug' => Generator::generateSlug(ActivityStatus::class, $name)
            ]);
        }

        $names = ['Menunggu Penerimaan', 'Sudah Diterima', 'Sudah Ditolak', 'Menunggu Clock-In', 'Menunggu Clock-Out', 'Sudah Hadir'];
        foreach ($names as $name) {
            SukarelawanStatus::create([
                'id' => Generator::generateId(SukarelawanStatus::class),
                'name' => $name,
                'slug' => Generator::generateSlug(SukarelawanStatus::class, $name)
            ]);
        }

        $names = ['Menunggu Pencairan', 'Sudah Dicairkan'];
        foreach ($names as $name) {
            ExperiencePointStatus::create([
                'id' => Generator::generateId(ExperiencePointStatus::class),
                'name' => $name,
                'slug' => Generator::generateSlug(ExperiencePointStatus::class, $name)
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

        Artisan::call('app:fetch-provinces');

        Artisan::call('app:fetch-cities');

        $name = 'Sungai Ciliwung';
        River::create([
            'id' => Generator::generateId(River::class),
            'cityId' => City::where('name', 'Kota Jakarta Utara')->first()->id,
            'name' => $name,
            'locationUrl' => 'https://maps.app.goo.gl/qJZgk1uYFzEmb2ZQ8',
            'slug' => Generator::generateSlug(River::class, $name)
        ]);
    }
}
