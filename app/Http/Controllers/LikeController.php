<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Services\TMDB\TmdbMoviesInformationApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LikeController extends Controller
{
    protected $tmdbApi;
    protected $movie;

    public function __construct(TmdbMoviesInformationApi $tmdbApi, Movie $movie)
    {
        $this->tmdbApi = $tmdbApi;
        $this->movie = $movie;
    }

    public function index()
    {
        $moviesIds = $this->movie->getLikedMoviesIds(Auth::user());

        $ids = array_map(function ($movie) {
            return $movie->movie_id;
        }, $moviesIds->items());

        $movies = $this->tmdbApi->getMoviesById($ids);
        $movies = $this->movie->markLikedMovies($movies);
        $movies = $this->movie->markWatchedMovies($movies);

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
        $movies = $this->movie->markWatchedMovies($movies);

        return $movies;
    }

    public function handleLike($id)
    {
        $this->movie->handleLike($id);
    }
}
