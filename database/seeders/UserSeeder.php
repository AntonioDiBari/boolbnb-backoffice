<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['Antonio', 'Luca', 'Carmine', 'Francesco', 'Andrea'];
        $surnames = ['Di Bari', 'Lillo', 'Miele', 'Cesari', 'Sirpa'];
        $dates = ['1999-09-24', '1999-10-01', '2002-04-23', '1997-11-07', '1999-12-19'];
        $emails = ['antonio@gmail.com', 'luca@gmail.com', 'carmine@gmail.com', 'francesco@gmail.com', 'andrea@gmail.com'];

        for ($i = 0; $i <= 4; $i++) {

            $user = new User;

            $user->name = $names[$i];
            $user->surname = $surnames[$i];
            $user->date_of_birth = $dates[$i];
            $user->email = $emails[$i];
            $user->password = Hash::make("Boolean117!");

            $user->save();
        }
    }
}
