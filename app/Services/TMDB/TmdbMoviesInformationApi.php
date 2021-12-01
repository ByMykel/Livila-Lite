<?php

namespace App\Services\TMDB;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class TmdbMoviesInformationApi
{
    public function getMovies($page = 1)
    {
        $movies = [];

        $response = Http::get('https://api.themoviedb.org/3/discover/movie', [
            'api_key' => Config::get('services.tmdb.key'),
            'include_adult' => false,
            'page' => $page
        ]);

        if ($response->ok()) {
            $movies = $response->json();
        }

        return $movies;
    }
}