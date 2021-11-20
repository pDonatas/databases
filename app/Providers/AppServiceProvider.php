<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laudis\Neo4j\Authentication\Authenticate;
use Laudis\Neo4j\Client;
use Laudis\Neo4j\ClientBuilder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(Client::class, function() {
            return ClientBuilder::create()
                ->withDriver('bolt', 'bolt://'.env('NEO4J_USER').':'.env('NEO4J_PASSWORD').'@'.env('NEO4J_BOLT_HOST').'?database='.env('NEO4J_DATABASE')) // creates a bolt driver
                ->withDriver('https', 'http://'.env('NEO4J_HTTP_HOST'), Authenticate::basic(env('NEO4J_USER'), env('NEO4J_PASSWORD'))) // creates an http driver
                ->withDriver('neo4j', 'neo4j://'.env('NEO4J_NEO_HOST').'?database='.env('NEO4J_DATABASE'), Authenticate::kerberos(env('NEO4J_TOKEN'))) // creates an auto routed driver
                ->withDefaultDriver('bolt')
                ->build();
        });
    }
}
