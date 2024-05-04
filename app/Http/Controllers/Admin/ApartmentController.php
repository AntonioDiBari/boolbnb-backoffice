<?php

namespace App\Http\Controllers\Admin;

use App\Models\Apartment;
use App\Http\Controllers\Controller;

use App\Models\Service;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
    //  * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();
        $apartments = Apartment::where('user_id', $id)->paginate(10);

            $apiKey = "J3iuAWIFiXr0BqrC4gh2RHMmzjR7mdUt";
            $addresses = [];
            foreach ($apartments as $apartment) {
                $address_path = "https://api.tomtom.com/search/2/reverseGeocode/{$apartment->latitude},{$apartment->longitude}.json?key={$apiKey}";
                $address_json = file_get_contents($address_path);
                $address_obj = json_decode($address_json);
                array_push($addresses, $address_obj->addresses[0]->address->freeformAddress);
            }
            
        return view('admin.apartments.index', compact('apartments', 'addresses'));
    }

    /**
     * Show the form for creating a new resource.
     *
    //  * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $apartment = new Apartment;
        $services = Service::all();
        return view('admin.apartments.form', compact('apartment', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $apiKey = "J3iuAWIFiXr0BqrC4gh2RHMmzjR7mdUt";
        $request->validated();
        $data = $request->all();
        
        $apartment = new apartment();
        $apartment->fill($data);
        $address_path = str_replace("%20", " ", $apartment->address);
        $coordinate_path = "https://api.tomtom.com/search/2/geocode/{$apartment->n_address}%20{$address_path},%20{$apartment->city},%20{$apartment->country}.json?key={$apiKey}";
        $coordinate_json = file_get_contents($coordinate_path);
        $coordinate_obj = json_decode($coordinate_json);
        array_push($apartment->latitude, $coordinate_obj->results->position->lat);
        array_push($apartment->longitude, $coordinate_obj->results->position->lon);
        $apartment->save();


        if (array_key_exists('services', $data)) {
            $apartment->services()->attach($data['services']);
        }

        return redirect()->route('admin.apartments.show', $apartment);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
    //  * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        return view('admin.apartments.show', compact('apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
    //  * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        $services = Service::all();
        // $apartment_service_id = $apartment->services->pluck('id')->toArray();
        return view('admin.apartments.form', compact('apartment', 'services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Apartment  $apartment
    //  * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apartment $apartment)
    {
        $request->validated();
        $data = $request->all();
        
        $apartment->update($data);
        
        if (array_key_exists('services', $data)) {
            $apartment->services()->attach($data['services']);
        }

        return redirect()->route('admin.apartments.show', $apartment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apartment  $apartment
    //  * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
        $apartment->delete();
        return redirect()->route('admin.apartments.index');
    }
}