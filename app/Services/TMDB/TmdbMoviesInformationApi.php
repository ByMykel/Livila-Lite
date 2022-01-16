<?php

namespace App\Services\TMDB;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class TmdbMoviesInformationApi
{
    public function getMovies($page = 1)
    {
        $response = Http::get('https://api.themoviedb.org/3/discover/movie', [
            'api_key' => Config::get('services.tmdb.key'),
            'include_adult' => false,
            'page' => $page
        ]);

        if ($response->ok()) {
            $movies = $response->json();
        }

        return $movies ?? [];
    }

    public function getTopRatedMovies($page = 1)
    {
        $response = Http::get('https://api.themoviedb.org/3/movie/top_rated', [
            'api_key' => Config::get('services.tmdb.key'),
            'page' => $page
        ]);

        if ($response->ok()) {
            $movies = $response->json();
        }

        return $movies ?? [];
    }

    public function getMovieById($id)
    {
        $response = Http::get('https://api.themoviedb.org/3/movie/' . $id, [
            'api_key' => Config::get('services.tmdb.key'),
        ]);

        if ($response->ok()) {
            $movie = $response->json();
        }

        return $movie ?? [];
    }

    public function getMoviesById($moviesIds)
    {
        foreach ($moviesIds as $id) {
            $movie = $this->getMovieById($id);

            if ($movie) {
                $movies[] = $movie;
            }
        }

        return $movies ?? [];
    }
}
