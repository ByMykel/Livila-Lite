<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Services\TMDB\TmdbMoviesInformationApi;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MovieController extends Controller
{
    protected $tmdbApi;

    public function __construct(TmdbMoviesInformationApi $tmdbApi, Movie $movie)
    {
        $this->tmdbApi = $tmdbApi;
        $this->movie = $movie;
    }

    public function index()
    {
        $movies = $this->tmdbApi->getMovies();

        $movies['results'] = $this->movie->markLikedMovies($movies['results']);
        $movies['results'] = $this->movie->markWatchedMovies($movies['results']);

        return Inertia::render('Movies', [
            'movies' => $movies['results']
        ]);
    }

    public function show($id)
    {
        $movie = $this->tmdbApi->getMovie($id);

        $movie = $this->movie->markLikedMovies($movie);
        $movie = $this->movie->markWatchedMovies($movie);

        return $movie;
    }

    public function movies($page)
    {
        $movies = $this->tmdbApi->getMovies($page);

        $movies['results'] = $this->movie->markLikedMovies($movies['results']);
        $movies['results'] = $this->movie->markWatchedMovies($movies['results']);

        return $movies;
    }
}
