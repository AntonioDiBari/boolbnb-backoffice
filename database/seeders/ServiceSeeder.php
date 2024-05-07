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
                'logo' => 'wifi'
            ],
            [
                'name' => 'Posto Macchina',
                'logo' => 'square-parking'
            ],
            [
                'name' => 'Piscina',
                'logo' => 'person-swimming'
            ],
            [
                'name' => 'Portineria',
                'logo' => 'bell-concierge'
            ],
            [
                'name' => 'Sauna',
                'logo' => 'hot-tub-person'
            ],
            [
                'name' => 'Vista Mare',
                'logo' => 'water'
            ],
            [
                'name' => 'Giardino',
                'logo' => 'seedling'
            ],
            [
                'name' => 'Ascensore',
                'logo' => 'elevator'
            ],
            [
                'name' => 'Animali ammessi',
                'logo' => 'paw'
            ],
            [
                'name' => 'Aria Condizionata',
                'logo' => 'snowflake'
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
