<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function store(Request $request, $id)
    {

        $data = $request->all();
        $data['apartment_id'] = $id;

        $validator = Validator::make($data, [
            'email' => ['required', 'email'],
            'body' => 'required',
            'sent' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ]);
        }

        $new_message = new Message();
        $new_message->fill($data);
        $new_message->save();

        return response()->json([
            'success' => true,
        ]);
    }
}