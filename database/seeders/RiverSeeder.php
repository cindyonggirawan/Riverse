<?php

namespace Database\Seeders;

use App\Models\River;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RiverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        River::factory()
        ->createMany([
            [
                'addressLink' => 'test.com',
                'banner' => 'Sungai Ciliwung'
            ],
            [
                'addressLink' => 'test2.com',
                'banner' => 'Sungai Ciliwung 2'
            ]
        ]);
    }
}
