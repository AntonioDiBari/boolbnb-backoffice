<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{
    public function getImageUrls()
    {
        $imageFolder = public_path('img');
        $imageUrls = [];

        $imageFiles = File::files($imageFolder);

        foreach ($imageFiles as $imageFile) {
            $imageUrls[] = asset('img/' . $imageFile->getFilename());
        }

        return response()->json($imageUrls);

        // return view('home')->with('imageUrls', $imageUrls);
    }
}
