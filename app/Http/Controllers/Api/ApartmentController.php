<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function indexSponsor()
    {
        $apartments = Apartment::where('visible', true )->whereHas('sponsors')->with(['services:id,name,logo', 'sponsors:id,name,duration,price'])->paginate(20);
        
        foreach ($apartments as $apartment) {
            if (str_starts_with($apartment->img, 'img')) {
                $apartment->img = asset($apartment->img);
            } elseif (str_starts_with($apartment->img, 'uploads')) {
                $apartment->img = asset('storage/' . $apartment->img);
            } else {
                $apartment->img = "https://placehold.co/600x400";
            }
        }

        return response()->json([
            'result' => $apartments,
            'success' => true,
        ]);
    }
    public function index(Request $request)
    {
        $query = Apartment::query();

        if($request->has('beds') && $request['beds'] != 0) {
            $query->where('n_beds', '>=', $request['beds']);
        }

        if($request->has('rooms') && $request['rooms'] != 0) {
            $query->where('n_rooms', '>=', $request['rooms']);
        }

        if($request->has('services') && $request['services'] != []) {
            $services = $request['services'];
            $query->whereHas('services', function ($q) use ($services) {
                $q->whereIn('service_id', $services);
            }, '=', count($services));
        }

        if($request->has('address') && $request['address'] != "") {
            $apiKey = "J3iuAWIFiXr0BqrC4gh2RHMmzjR7mdUt";
            
            $address_path = str_replace(" ", "%20", $request['address']);
            $coordinate_path = "https://api.tomtom.com/search/2/geocode/{$address_path}.json?key={$apiKey}";
            $coordinate_json = file_get_contents($coordinate_path);
            $coordinate_obj = json_decode($coordinate_json);
            $latitude = $coordinate_obj->results[0]->position->lat;
            $longitude = $coordinate_obj->results[0]->position->lon;

            $query->whereRaw('ST_Distance( POINT(apartments.longitude, apartments.latitude),POINT(' . $longitude . ',' . $latitude . ')) < ' . $request['range'] / 100);
        }
        
        $apartments = $query->where('visible', true )->with(['services:id,name,logo', 'sponsors:id,name,duration,price'])->get()->toArray();
        
        $sponsoredApartments = [];
        
        foreach ($apartments as $index => $apartment) {
            if ($apartment['sponsors'] != []) {
                unset($apartments[$index]);
                array_push($sponsoredApartments, $apartment);
            }
        }

        foreach($sponsoredApartments as $sponsoredApartment) {
            array_unshift($apartments, $sponsoredApartment);
        }
        foreach ($apartments as $apartment) {
            if (str_starts_with($apartment['img'], 'img')) {
                $apartment['img'] = asset($apartment['img']);
            } elseif (str_starts_with($apartment['img'], 'uploads')) {
                $apartment['img'] = asset('storage/' . $apartment['img']);
            } elseif ($apartment['img'] = '') {
                // ******Debug********
                $apartment['img'] = "https://placehold.co/600x400";
            }
            // ******Aggiungere address in array apartment************
        }

        return response()->json([
            'success' => true,
            'result' => $apartments,
        ]);
    }
    public function show($slug)
    {
        $apartment = apartment::where('slug', $slug)->with(['users:id,name,surname,date_of_birth,email','services:id,name,logo', 'sponsors:id,name,duration,price'])->first();
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
            };


        return response()->json([
            'result' => $apartment,
            'success' => true,
        ]);
    }
}