<?php

const FORMAL_REGISTER_URL = 'http://192.168.10.10/members/formal/';
const LOGIN_URL = 'http://192.168.10.10/members/login';
const REMIND_JUDGMENT_TIME = '+10 minute';

return [
    'Datasources' => [
        'default' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'host' => 'localhost',
            //'port' => 'non_standard_port_number',
            'username' => 'vagrant',
            'password' => '',
            'database' => 'practice',
            'encoding' => 'utf8',
            // 'timezone' => 'UTC',
            // 'flags' => [],
            // 'cacheMetadata' => true,
            'quoteIdentifiers' => false,
            'log' => false,
            //'init' => ['SET GLOBAL innodb_stats_on_metadata = 0'],
            'url' => env('DATABASE_URL', null),
            //'unix_socket' => '/var/lib/mysql/mysql.sock',
        ],

        /**
         * The test connection is used during the test suite.
         */
        'test' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'host' => 'localhost',
            //'port' => 'non_standard_port_number',
            'username' => 'vagrant',
            'password' => '',
            'database' => 'practice_test',
            'encoding' => 'utf8',
            // 'timezone' => 'UTC',
            // 'cacheMetadata' => true,
            'quoteIdentifiers' => false,
            'log' => false,
            //'init' => ['SET GLOBAL innodb_stats_on_metadata = 0'],
            'url' => env('DATABASE_TEST_URL', null),
        ],
    ],
];
