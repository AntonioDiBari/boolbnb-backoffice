<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Apartment;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        $messages = Message::all()->orderBy('sent', 'desc')->get();

        return view('admin.messages.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     *
     */
    public function show(Apartment $apartment, Message $message)
    {
        // $messages = Message::orderByDesc('sent')->get();
        // $messages_array = $messages->toArray();
        // $email = $message->email;
        // $apartment_id = $message->apartment_id;
        // $messages_filter = array_filter($messages_array, function ($mes) use ($email, $apartment_id) {
        //     return $mes['email'] == $email && $mes['apartment_id'] == $apartment_id;
        // });
        $messages = Message::where('email', $message->email)->where('apartment_id', $message->apartment_id)->orderByDesc('sent')->get();
        $messages_array = $messages->toArray();

        return view('admin.messages.show', compact('messages_array', 'apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}