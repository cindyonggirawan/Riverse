<?php

namespace Database\Seeders;

use App\Models\Fasilitator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FasilitatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Fasilitator::factory()
        ->createMany([
            [
                'name' => 'Pandawa Group',
                'description' => 'Pandawa group terdiri dari anak-anak milenial',
                'status' => 'UNVERIFIED',
                'password' => Hash::make('12345678'),
                'email' => 'pandawagroup@gmail.com',
                'picture' => 'images/placeholder2.jpeg',
                'phoneNumber' => '0812696969',
                'type' => 'Social Organization'
            ]
        ]);
    }
}
