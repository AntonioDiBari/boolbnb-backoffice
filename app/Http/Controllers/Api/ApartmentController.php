<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    // *****Funzione che ci ritorna indietro solo gli appartamenti che hanno almeno una sponsor*****
    public function indexSponsor()
    {
        $apiKey = env('TOMTOM_API_KEY');

        // $apiKey = "J3iuAWIFiXr0BqrC4gh2RHMmzjR7mdUt";
        // $apiKey = "ONRDNhUryVFGib0NMGnBqiPEWGkuIQvI";


        $apartments = Apartment::where('visible', true)->whereHas('sponsors')->with(['services:id,name,logo', 'sponsors:id,name,duration,price'])->get();

        $addresses = [];
        // *****Gestione dell'img dell'appartamento*****
        foreach ($apartments as $apartment) {
            if (str_starts_with($apartment->img, 'img')) {
                $apartment->img = asset($apartment->img);
            } elseif (str_starts_with($apartment->img, 'uploads')) {
                $apartment->img = asset('storage/' . $apartment->img);
            } else {
                $apartment->img = "https://placehold.co/600x400";
            }

            // *****Push di address in apartment*****
            $address_path = "https://api.tomtom.com/search/2/reverseGeocode/{$apartment['latitude']},{$apartment['longitude']}.json?key={$apiKey}";
            $address_json = file_get_contents($address_path);
            $address_obj = json_decode($address_json);
            array_push($addresses, $address_obj->addresses[0]->address->freeformAddress);
        }

        return response()->json([
            'result' => $apartments,
            'success' => true,
            'addresses' => $addresses,
        ]);
    }

    // *****Funzione che gestisce i filtri della ricerca avanzata*****
    public function index(Request $request)
    {
        $query = Apartment::query();

        // *****Filtro letti*****
        if ($request->has('beds') && $request['beds'] != 0) {
            $query->where('n_beds', '>=', $request['beds']);
        }

        // *****Filtro camere*****
        if ($request->has('rooms') && $request['rooms'] != 0) {
            $query->where('n_rooms', '>=', $request['rooms']);
        }

        // *****Filtro servizi*****
        if ($request->has('services') && $request['services'] != []) {
            $services = $request['services'];
            $query->whereHas('services', function ($q) use ($services) {
                $q->whereIn('service_id', $services);
            }, '>=', count($services));
        }

        // *****Filtro search-bar*****
        $apiKey = env('TOMTOM_API_KEY');

        // $apiKey = "J3iuAWIFiXr0BqrC4gh2RHMmzjR7mdUt";
        // $apiKey = "ONRDNhUryVFGib0NMGnBqiPEWGkuIQvI";

        if ($request->has('address') && $request['address'] != "") {

            $address_path = str_replace(" ", "%20", $request['address']);
            $coordinate_path = "https://api.tomtom.com/search/2/geocode/{$address_path}.json?key={$apiKey}";
            $coordinate_json = file_get_contents($coordinate_path);
            $coordinate_obj = json_decode($coordinate_json);
            $latitude = $coordinate_obj->results[0]->position->lat;
            $longitude = $coordinate_obj->results[0]->position->lon;

            $query->whereRaw('ST_Distance( POINT(apartments.longitude, apartments.latitude),POINT(' . $longitude . ',' . $latitude . ')) < ' . $request['range'] / 100);
        }

        $apartments = $query->where('visible', true)->with(['services:id,name,logo', 'sponsors:id,name,duration,price'])->get()->toArray();

        $sponsoredApartments = [];

        // *****Ordinamento appartamenti per sponsor*****
        foreach ($apartments as $index => $apartment) {
            if ($apartment['sponsors'] != []) {
                unset($apartments[$index]);
                array_push($sponsoredApartments, $apartment);
            }
        }

        foreach ($sponsoredApartments as $sponsoredApartment) {
            array_unshift($apartments, $sponsoredApartment);
        }

        $addresses = [];
        // *****Gestione dell'img dell'appartamento*****
        foreach ($apartments as $index => $apartment) {
            if (str_starts_with($apartment['img'], 'img')) {
                $apartments[$index]['img'] = asset($apartment['img']);
            } elseif (str_starts_with($apartment['img'], 'uploads')) {
                $apartments[$index]['img'] = asset('storage/' . $apartment['img']);
            } elseif ($apartment['img'] == null) {
                $apartments[$index]['img'] = "https://placehold.co/600x400";
            }

            // *****Push di address in apartment*****
            $address_path = "https://api.tomtom.com/search/2/reverseGeocode/{$apartment['latitude']},{$apartment['longitude']}.json?key={$apiKey}";
            $address_json = file_get_contents($address_path);
            $address_obj = json_decode($address_json);
            array_push($addresses, $address_obj->addresses[0]->address->freeformAddress);
        }

        // dd($apartments);
        return response()->json([
            'success' => true,
            'result' => $apartments,
            'addresses' => $addresses,
        ]);

    }

    // *****Dettaglio dell'appartamento*****
    public function show($slug)
    {
        $apartment = apartment::where('slug', $slug)->with(['user:id,name,surname,date_of_birth,email', 'services:id,name,logo', 'sponsors:id,name,duration,price'])->first();
        if (empty($apartment)) {
            return response()->json([
                'message' => 'Appartamento non trovato',
                'success' => false,
            ]);
        }
        if (str_starts_with($apartment->img, 'img')) {
            $apartment->img = asset($apartment->img);
        } elseif (str_starts_with($apartment->img, 'uploads')) {
            $apartment->img = asset('storage/' . $apartment->img);
        } else {
            $apartment->img = "https://placehold.co/600x400";
        }
        ;
        $apiKey = env('TOMTOM_API_KEY');

        // $apiKey = "J3iuAWIFiXr0BqrC4gh2RHMmzjR7mdUt";
        // $apiKey = "ONRDNhUryVFGib0NMGnBqiPEWGkuIQvI";

        $address = [];
        // *****Push di address in apartment*****
        $address_path = "https://api.tomtom.com/search/2/reverseGeocode/{$apartment['latitude']},{$apartment['longitude']}.json?key={$apiKey}";
        $address_json = file_get_contents($address_path);
        $address_obj = json_decode($address_json);
        array_push($address, $address_obj->addresses[0]->address->freeformAddress);

        return response()->json([
            'result' => $apartment,
            'success' => true,
            'address' => $address,
        ]);
    }

    public function services()
    {
        $services = Service::all();
        return response()->json([
            'result' => $services,
            'success' => true,
        ]);
    }

}