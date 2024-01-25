<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    public function index()
    {
        $baseURL = env('MOVIE_DB_BASE_URL');
        $imageBaseURL = env('MOVIE_DB_IMAGE_BASE_URL');
        $apiKey = env('MOVIE_DB_API_KEY');
        $MAX_BANNER = 3;

        // Hit API Banner
        $bannerResponse = Http::get("{$baseURL}/trending/movie/week", [
            'api_key' => $apiKey,
        ]);

        // Prepare variable
        $bannerArray = [];
        // Check API response
        if ($bannerResponse->successful()){
            // Check data is null or not
            $resultArray = $bannerResponse->object()->results;

            if (isset($resultArray)){
                // Looping response data
                foreach ($resultArray as $item){
                    // Save response data to new variable
                    array_push($bannerArray, $item);

                    // Max 3 items
                    if (count($bannerArray) == $MAX_BANNER){
                        break;
                    }
                }
            }
        }

        return view('home', [
            'baseURL' => $baseURL,
            'imageBaseURL' => $imageBaseURL,
            'apiKey' => $apiKey,
            'banner' => $bannerArray
        ]);
    }
}
