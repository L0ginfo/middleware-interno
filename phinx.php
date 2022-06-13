<?php

$config = __DIR__ . DS . 'config' . DS;
$dotenv = new \josegonzalez\Dotenv\Loader([$config . '.env']);

$dotenv->parse()
    ->putenv(true)
    ->toEnv(true)
    ->toServer(true);
$aCharset = env('DB_ADAPTER', 'mysql') == 'mysql' ? ['charset' => 'utf8'] : [];
return
[
    'paths' => [
        'migrations' => __DIR__ . DS . 'config/db/migrations',
        'seeds' => __DIR__ . DS . 'config/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'development',
        'development' => [
            'adapter' => env('DB_ADAPTER', 'mysql'),
            'host' => env('DB_HOST', 'localhost'),
            'name' => env('DB_NAME', 'wms'),
            'user' => env('DB_USER', 'root'),
            'pass' => env('DB_PASS', ''),
            // 'port' => env('DB_PORT', '3306'),
            // 'charset' => 'utf8',
        ] + $aCharset
    ],
    'version_order' => 'creation'
];
