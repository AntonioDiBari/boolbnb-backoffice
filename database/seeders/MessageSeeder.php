<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        // prendo gli appartamenti
        $apartments = Apartment::all();

        // genero 10 messaggi per appartamento
        foreach ($apartments as $apartment) {
            for ($i = 0; $i < 10; $i++) {
                $message = new Message;
                $message->apartment_id = $apartment->id;
                $message->email = $faker->email();
                $message->body = $faker->paragraph;
                $message->sent = $faker->dateTimeBetween('-1month', 'now');
                $message->save();
            }
        }
    }
}
