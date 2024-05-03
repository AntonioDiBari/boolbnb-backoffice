<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;


class ApartmentServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $apartments = Apartment::all();
        $services = Service::all()->pluck('id')->toArray();

        foreach ($apartments as $apartment) {
            $apartment->services()->attach($faker->randomElements($services, random_int(1, 10)));
        }
    }
}
