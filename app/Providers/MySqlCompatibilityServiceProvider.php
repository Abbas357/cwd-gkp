<?php

namespace App\Providers;

use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Grammars\MySqlGrammar;
use Illuminate\Database\MySqlConnection;
use Illuminate\Support\ServiceProvider;

class MySqlCompatibilityServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }
    
    public function boot(): void
    {
        Connection::resolverFor('mysql', function ($connection, $database, $prefix, $config) {
            $connection = new MySqlConnection($connection, $database, $prefix, $config);
            $connection->setSchemaGrammar($this->createCustomGrammar($connection));
            return $connection;
        });
    }

    protected function createCustomGrammar($connection)
    {
        return new class extends MySqlGrammar {
            public function compileGetColumns($database, $table)
            {
                return "select column_name, data_type, column_type, collation_name, 
                        is_nullable, column_default, column_comment, extra 
                        from information_schema.columns 
                        where table_schema = ? and table_name = ? 
                        order by ordinal_position asc";
            }
        };
    }
}