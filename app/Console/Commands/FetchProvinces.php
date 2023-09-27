<?php

namespace App\Console\Commands;

use App\Models\Generator;
use App\Models\Province;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchProvinces extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-provinces';

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
        $response = Http::get('https://kanglerian.github.io/api-wilayah-indonesia/api/provinces.json');
        $data = $response->json();

        foreach ($data as $item) {
            $number = str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT);

            Province::create([
                'id' => 'PE' . $item['id'] . $number,
                'name' => ucwords(strtolower($item['name'])),
                'slug' => Generator::generateSlug(Province::class, $item['name'])
            ]);
        }

        $this->info('Provinces successfully fetched');
    }
}