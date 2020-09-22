<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'ARCommunity'),
            'username' => env('DB_USERNAME', 'garry'),
            'password' => env('DB_PASSWORD', 'TheKeeper'),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'mysql2' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST2', '127.0.0.1'),
            'port' => env('DB_PORT2', '3306'),
            'database' => env('DB_DATABASE2', 'ARManagement'),
            'username' => env('DB_USERNAME2', 'garry'),
            'password' => env('DB_PASSWORD2', 'TheKeeper'),
            'unix_socket' => env('DB_SOCKET2', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'mysql3' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST3', '127.0.0.1'),
            'port' => env('DB_PORT3', '3306'),
            'database' => env('DB_DATABASE3', 'ARDatabase'),
            'username' => env('DB_USERNAME3', 'garry'),
            'password' => env('DB_PASSWORD3', 'TheKeeper'),
            'unix_socket' => env('DB_SOCKET3', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'mysql4' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST4', '127.0.0.1'),
            'port' => env('DB_PORT4', '3306'),
            'database' => env('DB_DATABASE4', 'ARAccounting'),
            'username' => env('DB_USERNAME4', 'garry'),
            'password' => env('DB_PASSWORD4', 'TheKeeper'),
            'unix_socket' => env('DB_SOCKET4', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST5', '127.0.0.1'),
            'port' => env('DB_PORT5', '5432'),
            'database' => env('DB_DATABASE5', 'forge'),
            'username' => env('DB_USERNAME5', 'forge'),
            'password' => env('DB_PASSWORD5', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST6', 'localhost'),
            'port' => env('DB_PORT6', '1433'),
            'database' => env('DB_DATABASE6', 'forge'),
            'username' => env('DB_USERNAME6', 'forge'),
            'password' => env('DB_PASSWORD6', ''),
            'charset' => 'utf8',
            'prefix' => '',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => 'predis',

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_DB', 0),
        ],

        'cache' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_CACHE_DB', 1),
        ],

    ],

];
