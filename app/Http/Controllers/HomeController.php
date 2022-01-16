<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Services\TMDB\TmdbMoviesInformationApi;
use Inertia\Inertia;

class HomeController extends Controller
{
    protected $tmdbApi;

    public function __construct(TmdbMoviesInformationApi $tmdbApi, Movie $movie)
    {
        $this->tmdbApi = $tmdbApi;
        $this->movie = $movie;
    }

    public function index()
    {
        $movies = $this->tmdbApi->getTopRatedMovies();

        $movies['results'] = $this->movie->markLikedMovies($movies['results']);
        $movies['results'] = $this->movie->markWatchedMovies($movies['results']);

        return Inertia::render('Home', [
            'movies' => $movies['results']
        ]);
    }

    public function movies($page)
    {
        $movies = $this->tmdbApi->getTopRatedMovies($page);

        $movies['results'] = $this->movie->markLikedMovies($movies['results']);
        $movies['results'] = $this->movie->markWatchedMovies($movies['results']);

        return $movies;
    }
}
