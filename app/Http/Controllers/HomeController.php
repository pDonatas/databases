<?php

namespace App\Http\Controllers;

use App\Http\Factory\Neo4jEntityFactory;
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Client $client)
    {
        // Test for neo4j db
        $result = $client->runStatement(Statement::create('MATCH (n) RETURN n'));

        $data = [];

        foreach($result as $item) {
            $data[] = Neo4jEntityFactory::create($item);
        }

        return view('home', compact('data'));
    }
}
