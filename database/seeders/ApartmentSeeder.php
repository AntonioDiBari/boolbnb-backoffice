<?php

namespace Database\Seeders;

use App\Models\Apartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $file = fopen(__DIR__ . '/../csv/apartments.csv', 'r');
        $first_line = true;
        while (!feof($file)) {
            $apartments_data = fgetcsv($file);
            if ($apartments_data) {
                if (!$first_line) {
                    $apartment = new Apartment();

                    $apartment->user_id = $faker->numberBetween(1, 5);
                    $apartment->title_desc = $apartments_data[0];
                    $apartment->slug = Str::slug($apartment->title_desc);
                    $apartment->n_rooms = $faker->numberBetween(1, 5);
                    $apartment->n_bathrooms = $faker->numberBetween(1, 3);
                    $apartment->n_beds = $faker->numberBetween(1, 4);
                    $apartment->square_mts = $faker->numberBetween(80, 170);
                    $apartment->img = $apartments_data[1];
                    $apartment->visible = true;
                    $apartment->latitude = $apartments_data[2];
                    $apartment->longitude = $apartments_data[3];

                    $apartment->save();
                }
                $first_line = false;
            }
        }
    }
}
