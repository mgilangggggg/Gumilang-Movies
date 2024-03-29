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
        $MAX_MOVIE_ITEM = 10;
        $MAX_TV_SHOWS_ITEM = 10;

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
        
        // Hit API Top 10 Movie
        $topMoviesResponse = Http::get("{$baseURL}/movie/top_rated", [
            'api_key' => $apiKey,
        ]);

        // Prepare variable
        $topMoviesArray = [];
        // Check API response
        if ($topMoviesResponse->successful()) {
            // Check data is null or not
            $resultArray = $topMoviesResponse->object()->results;

            if(isset($resultArray)) {
                // Looping response data
                foreach ($resultArray as $item){
                    // Save response data to new variable
                    array_push($topMoviesArray, $item);
                    
                    // Max 10 items
                    if (count($topMoviesArray) == $MAX_MOVIE_ITEM){
                        break;
                    }
                }
            }
        }

        // Hit API Top 10 TV Shows
        $topTVShowsResponse = Http::get("{$baseURL}/tv/top_rated", [
            'api_key' => $apiKey,
        ]);

        // Prepare variable
        $topTVShowArray = [];
        // Check API response
        if ($topTVShowsResponse->successful()) {
            // Check data is null or not
            $resultArray = $topTVShowsResponse->object()->results;

            if(isset($resultArray)) {
                // Looping response data
                foreach ($resultArray as $item){
                    // Save response data to new variable
                    array_push($topTVShowArray, $item);
                    
                    // Max 10 items
                    if (count($topTVShowArray) == $MAX_TV_SHOWS_ITEM){
                        break;
                    }
                }
            }
        }

        return view('home', [
            'baseURL' => $baseURL,
            'imageBaseURL' => $imageBaseURL,
            'apiKey' => $apiKey,
            'banner' => $bannerArray,
            'topMovies' => $topMoviesArray,
            'topTVShows' => $topTVShowArray
        ]);
    }

    public function movies() {
        $baseURL = env('MOVIE_DB_BASE_URL');
        $imageBaseURL = env('MOVIE_DB_IMAGE_BASE_URL');
        $apiKey = env('MOVIE_DB_API_KEY');
        $sortBy = "popularity.desc";
        $page = 1;
        $minimalVoter = 100;

        // Hit API discover
        $movieResponse = Http::get("{$baseURL}/discover/movie", [
            'api_key' => $apiKey,
            'sort_by' => $sortBy,
            'vote_count.gte' => $minimalVoter,
            'page' => $page
        ]);

        // Prepare variable
        $movieArray = [];
        // Check API response
        if ($movieResponse->successful()) {
            // Check data is null or not
            $resultArray = $movieResponse->object()->results;

            if(isset($resultArray)) {
                // Looping response data
                foreach ($resultArray as $item){
                    // Save response data to new variable
                    array_push($movieArray, $item);
                }
            }
        }

        return view('movie', [
            'baseURL' => $baseURL,
            'imageBaseURL' => $imageBaseURL,
            'apiKey' => $apiKey,
            'movies' => $movieArray,
            'sortBy' => $sortBy,
            'page' => $page,
            'minimalVoter' => $minimalVoter
        ]);
    }
}
