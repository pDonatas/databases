<?php

namespace App\Http\Controllers;

use App\Http\Factory\Neo4jEntityFactory;
use Illuminate\Contracts\Support\Renderable;
use Laudis\Neo4j\Client;
use Laudis\Neo4j\Databags\Statement;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('home');
    }
}
