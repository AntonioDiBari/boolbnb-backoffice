<?php

namespace Database\Seeders;

use App\Models\Sponsor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sponsors = [
            [
                'name' => 'Standard',
                'duration' => 24,
                'price' => 2.99,
            ],
            [
                'name' => 'Gold',
                'duration' => 72,
                'price' => 5.99,
            ],
            [
                'name' => 'Platinum',
                'duration' => 144,
                'price' => 9.99,
            ]
        ];

        foreach ($sponsors as $sponsor) {

            $sponsorPlan = new Sponsor();
            $sponsorPlan->name = $sponsor['name'];
            $sponsorPlan->duration = $sponsor['duration'];
            $sponsorPlan->price = $sponsor['price'];

            $sponsorPlan->save();
        }
    }
}
