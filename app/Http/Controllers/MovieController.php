<?php

namespace App\Http\Controllers;

use App\Services\TMDB\TmdbMoviesInformationApi;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MovieController extends Controller
{
    protected $tmdbApi;

    public function __construct(TmdbMoviesInformationApi $tmdbApi)
    {
        $this->tmdbApi = $tmdbApi;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = $this->tmdbApi->getMovies();

        return Inertia::render('Movies', [
            'movies' => $movies['results']
        ]);
    }

    public function movies($page)
    {
        $movies = $this->tmdbApi->getMovies($page);

        return $movies;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
