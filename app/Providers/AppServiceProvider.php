<?php

declare(strict_types=1);

namespace App\Providers;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Client::class, static function (): Client {
            $builder = ClientBuilder::create()
                ->setHosts([(string) config('elasticsearch.host')])
                ->setHttpClient(new HttpClient([
                    'timeout' => (int) config('elasticsearch.timeout'),
                    'connect_timeout' => 2,
                ]));

            if (config('elasticsearch.api_key')) {
                $builder->setApiKey((string) config('elasticsearch.api_key'));
            }

            return $builder->build();
        });
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
