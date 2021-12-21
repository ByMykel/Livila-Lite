<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Services\TMDB\TmdbMoviesInformationApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LikeController extends Controller
{
    protected $movie;

    public function __construct(TmdbMoviesInformationApi $tmdbApi, Movie $movie)
    {
        $this->tmdbApi = $tmdbApi;
        $this->movie = $movie;
    }

    public function index()
    {
        $moviesIds = $this->movie->getLikedMoviesIds(Auth::user());

        // dd($moviesIds);

        $ids = array_map(function ($movie) {
            return $movie->movie_id;
        }, $moviesIds->items());

        $movies = $this->tmdbApi->getMoviesById($ids);
        $movies = $this->movie->markLikedMovies($movies);

        return Inertia::render('Liked', [
            'movies' => $movies
        ]);
    }

    public function movies()
    {
        $moviesIds = $this->movie->getLikedMoviesIds(Auth::user());

        $ids = array_map(function ($movie) {
            return $movie->movie_id;
        }, $moviesIds->items());

        $movies = $this->tmdbApi->getMoviesById($ids);
        $movies = $this->movie->markLikedMovies($movies);

        return $movies;
    }

    public function handleLike($id)
    {
        $this->movie->handleLike($id);
    }
}
