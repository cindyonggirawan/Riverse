<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\Province;
use App\Models\Generator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchCities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-cities';

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
        $provinces = Province::orderBy('id', 'asc')
            ->get();

        foreach ($provinces as $province) {
            $provinceId = substr($province->id, 2, 2);

            $response = Http::get("https://kanglerian.github.io/api-wilayah-indonesia/api/regencies/$provinceId.json");
            $data = $response->json();

            foreach ($data as $item) {
                $number = str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

                City::create([
                    'id' => 'CY' . $item['id'] . $number,
                    'provinceId' => $province->id,
                    'name' => ucwords(strtolower($item['name'])),
                    'slug' => Generator::generateSlug(City::class, $item['name'])
                ]);
            }
        }

        $this->info('Cities successfully fetched');
    }
}
