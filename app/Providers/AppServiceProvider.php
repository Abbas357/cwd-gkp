<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Database\CustomMySqlGrammar;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot()
    {
        Paginator::useBootstrapFive();

        $this->app->resolving('db', function ($db) {
            $connection = $db->connection();
            if ($connection->getDriverName() === 'mysql') {
                $connection->setSchemaGrammar(new CustomMySqlGrammar);
            }
        });

    }
}
