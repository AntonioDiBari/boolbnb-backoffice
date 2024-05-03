<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            [
                'name' => 'WiFi',
                'logo' => '<i class="fa-solid fa-wifi"></i>'
            ],
            [
                'name' => 'Posto Macchina',
                'logo' => '<i class="fa-solid fa-square-parking"></i>'
            ],
            [
                'name' => 'Piscina',
                'logo' => '<i class="fa-solid fa-person-swimming"></i>'
            ],
            [
                'name' => 'Portineria',
                'logo' => '<i class="fa-solid fa-bell-concierge"></i>'
            ],
            [
                'name' => 'Sauna',
                'logo' => '<i class="fa-solid fa-hot-tub-person"></i>'
            ],
            [
                'name' => 'Vista Mare',
                'logo' => '<i class="fa-solid fa-water"></i>'
            ],
            [
                'name' => 'Giardino',
                'logo' => '<i class="fa-solid fa-seedling"></i>'
            ],
            [
                'name' => 'Ascensore',
                'logo' => '<i class="fa-solid fa-elevator"></i>'
            ],
            [
                'name' => 'Animali ammessi',
                'logo' => '<i class="fa-solid fa-paw"></i>'
            ],
            [
                'name' => 'Aria Condizionata',
                'logo' => '<i class="fa-solid fa-snowflake"></i>'
            ],
        ];

        foreach ($services as $serviceItem) {
            $service = new Service();
            $service->name = $serviceItem['name'];
            $service->logo = $serviceItem['logo'];

            $service->save();
        }

    }
}
