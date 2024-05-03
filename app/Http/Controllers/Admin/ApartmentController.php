<?php

namespace App\Http\Controllers\Admin;

use App\Models\Apartment;
use App\Http\Controllers\Controller;

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
        $apartments = Apartment::select(['title_desc', 'n_rooms', 'n_bathrooms', 'n_beds', 'square_mts', 'img', 'visible', 'latitude', 'longitude'])
            ->where('user_id', $id)->paginate(10);

            $apiKey = "J3iuAWIFiXr0BqrC4gh2RHMmzjR7mdUt";
            $addresses = [];
            foreach ($apartments as $key=>$apartment) {
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
    //  * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
    //  * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apartment  $apartment
    //  * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
        //
    }
}