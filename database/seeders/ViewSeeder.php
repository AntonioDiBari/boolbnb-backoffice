<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\View;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $apartments = Apartment::all();

        foreach ($apartments as $apartment) {

            $viewsNumber = $faker->numberBetween(0, 5000);

            for ($i = 0; $i < $viewsNumber; $i++) {
                $view = new View;
                $view->apartment_id = $apartment->id;
                $view->sent = $faker->dateTimeBetween('-1month', 'now');
                $view->ip_address = $faker->ipv6();
                $view->save();
            }
        }


    }
}
