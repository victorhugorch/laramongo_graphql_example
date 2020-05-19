<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestaurantCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jsonFile = file_get_contents(storage_path() . "/json/restaurants.json");
        $restaurants = json_decode($jsonFile, true);

        foreach ($restaurants as $restaurant) {
            DB::connection('mongodb')
                ->collection('restaurants')
                ->insert([
                    'id' => $restaurant['id'],
                    'tradingName' => $restaurant['tradingName'],
                    'ownerName' => $restaurant['ownerName'],
                    'cuisineType' => $restaurant['cuisineType'],
                    'document' => $restaurant['document'],
                    'coverageArea' => (object) $restaurant['coverageArea'],
                    'address' => (object) $restaurant['address']
                ]);
        }

        $this->command->info('RestaurantCollectionSeeder run successfully!');
    }
}
