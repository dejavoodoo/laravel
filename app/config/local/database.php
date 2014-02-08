<?php

return array(

    'connections' => array(

        'fmtdb' => array(
            'driver'    => 'mysql',
            'host'      => $_ENV['SQL_FMTDB']['host'],
            'database'  => $_ENV['SQL_FMTDB']['database'],
            'username'  => $_ENV['SQL_FMTDB']['username'],
            'password'  => $_ENV['SQL_FMTDB']['password'],
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ),

        'jsdb' => array(
            'driver'   => 'sqlsrv',
            'host'     => $_ENV['SQL_JSDB']['host'],
            'database' => $_ENV['SQL_JSDB']['database'],
            'username' => $_ENV['SQL_JSDB']['username'],
            'password' => $_ENV['SQL_JSDB']['password'],
            'prefix'   => '',
        ),

    ),

);
