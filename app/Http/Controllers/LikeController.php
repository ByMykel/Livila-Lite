<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LikeController extends Controller
{
    protected $movie;

    public function __construct(Movie $movie)
    {
        $this->movie = $movie;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Liked');
    }

    public function handleLike($id)
    {
        $this->movie->handleLike($id);

        return redirect()->back();
    }
}
