<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ApartmentRequest;
use App\Models\Apartment;
use App\Http\Controllers\Controller;

use App\Models\Service;
use App\Models\Sponsor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
    public function store(ApartmentRequest $request)
    {
        $id = Auth::id();
        $apiKey = "J3iuAWIFiXr0BqrC4gh2RHMmzjR7mdUt";
        $request->validated();
        $data = $request->all();

        $apartment = new apartment();
        $apartment->fill($data);

        $address_path = str_replace(" ", "%20", $data['address']);
        $coordinate_path = "https://api.tomtom.com/search/2/geocode/{$address_path}.json?key={$apiKey}";
        $coordinate_json = file_get_contents($coordinate_path);
        $coordinate_obj = json_decode($coordinate_json);
        $apartment->latitude = $coordinate_obj->results[0]->position->lat;
        $apartment->longitude = $coordinate_obj->results[0]->position->lon;
        $apartment->user_id = $id;

        if (array_key_exists('visible', $data)) {
            $apartment->visible = true;
        } else {
            $apartment->visible = false;
        }

        if (isset($data['img'])) {
            $img_path = Storage::put('uploads/apartments', $data['img']);
            $apartment->img = $img_path;
        }

        $apartment->save();


        if (array_key_exists('services', $data)) {
            $apartment->services()->attach($data['services']);
        }

        return redirect()->route('admin.apartments.index', $apartment)
            ->with("message", "Appartamento inserito con successo")
            ->with("type", "alert-success");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
    //  * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        if (Auth::user()->id != $apartment->user_id)
            abort(404);

        $apiKey = "J3iuAWIFiXr0BqrC4gh2RHMmzjR7mdUt";
        $address = [];
        $address_path = "https://api.tomtom.com/search/2/reverseGeocode/{$apartment->latitude},{$apartment->longitude}.json?key={$apiKey}";
        $address_json = file_get_contents($address_path);
        $address_obj = json_decode($address_json);
        array_push($address, $address_obj->addresses[0]->address->freeformAddress);

        return view('admin.apartments.show', compact('apartment', 'address'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
    //  * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        if (Auth::user()->id != $apartment->user_id)
            abort(404);
        $services = Service::all();
        $apiKey = "J3iuAWIFiXr0BqrC4gh2RHMmzjR7mdUt";
        $addresses = [];

        $address_path = "https://api.tomtom.com/search/2/reverseGeocode/{$apartment->latitude},{$apartment->longitude}.json?key={$apiKey}";
        $address_json = file_get_contents($address_path);
        $address_obj = json_decode($address_json);
        array_push($addresses, $address_obj->addresses[0]->address->street);
        array_push($addresses, $address_obj->addresses[0]->address->country);
        array_push($addresses, $address_obj->addresses[0]->address->municipality);
        array_push($addresses, $address_obj->addresses[0]->address->streetNumber);
        return view('admin.apartments.form', compact('apartment', 'services', 'addresses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Apartment  $apartment
    //  * @return \Illuminate\Http\Response
     */
    public function update(ApartmentRequest $request, Apartment $apartment)
    {
        $id = Auth::id();
        $apiKey = "J3iuAWIFiXr0BqrC4gh2RHMmzjR7mdUt";
        $request->validated();
        $data = $request->all();

        $apartment->update($data);

        $address_path = str_replace(" ", "%20", $data['address']);
        $coordinate_path = "https://api.tomtom.com/search/2/geocode/{$address_path}.json?key={$apiKey}";
        $coordinate_json = file_get_contents($coordinate_path);
        $coordinate_obj = json_decode($coordinate_json);
        $apartment->latitude = $coordinate_obj->results[0]->position->lat;
        $apartment->longitude = $coordinate_obj->results[0]->position->lon;
        $apartment->user_id = $id;

        if (array_key_exists('visible', $data)) {
            $apartment->visible = true;
        } else {
            $apartment->visible = false;
        }

        if (isset($data['img'])) {
            if (isset($apartment->img)) {
                Storage::delete($apartment->img);
            }
            $img_path = Storage::put('uploads/apartments', $data['img']);
            $apartment->img = $img_path;
        }

        $apartment->update();

        if (array_key_exists('services', $data)) {
            $apartment->services()->sync($data['services']);
        } else {
            $apartment->services()->detach();
        }

        return redirect()->route('admin.apartments.index', $apartment)
            ->with("message", "Appartamento aggiornato con successo")
            ->with("type", "alert-info");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apartment  $apartment
    //  * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
        $apartment->services()->detach();
        $apartment->delete();
        return redirect()->route('admin.apartments.index')
            ->with("message", "Appartamento eliminato con successo")
            ->with("type", "alert-info");
    }
}