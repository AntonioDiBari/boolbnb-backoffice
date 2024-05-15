<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Sponsor;
use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Symfony\Component\VarDumper\VarDumper;

class ApartmentSponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $apartments = Apartment::where('id', '>', 10)->get();
        // $sponsors = Sponsor::all()->pluck('id')->toArray();

        foreach ($apartments as $apartment) {
            $sponsorNumber = rand(1, 3);
            $created = $faker->dateTimeBetween('now', 'now');
            // $createdCopy = $created;
            $expiry = 0;
            if ($sponsorNumber == 1) {
                $expiry = date_add($faker->dateTimeBetween('now', 'now'), date_interval_create_from_date_string("24 hours"));
            } elseif ($sponsorNumber == 2) {
                $expiry = date_add($faker->dateTimeBetween('now', 'now'), date_interval_create_from_date_string("72 hours"));
            } elseif ($sponsorNumber == 3) {
                $expiry = date_add($faker->dateTimeBetween('now', 'now'), date_interval_create_from_date_string("144 hours"));
            }
            ;
            $apartment->sponsors()->syncWithPivotValues([$sponsorNumber], [
                'created' => $created,
                'expiry' => $expiry
            ]);
        }
    }
}