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
    public function index()
    {
        $apartments = Apartment::where('visible', true )->with(['services:id,name,logo', 'sponsors:id,name,duration,price'])->paginate(20);
        
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
    public function show($slug)
    {
        $apartment = apartment::where('slug', $slug)->with(['services:id,name,logo', 'sponsors:id,name,duration,price'])->first();
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