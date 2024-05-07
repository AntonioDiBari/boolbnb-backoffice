<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Sponsor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ApartmentSponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $apartments = Apartment::all();
        $sponsors = Sponsor::all()->pluck('id')->toArray();

        foreach ($apartments as $apartment) {
            $apartment->sponsors()->sync($faker->randomElements($sponsors, rand(1, 3)));
        }
    }
}
