<?php
ini_set("display_errors", "on");

return [
    //database
    'database.host'     => 'mysql',
    'database.port'     => 3306,
    'database.dbname'   => 'backend_sample_test',
    'database.user'     => 'root',
    'database.password' => '123456',
    'database.tablepre' => 'pcore_',
    //mongo
    'mongo.host' => 'mongodb://mongo:27017',
    'mongo.uriOptions' => [
    ],
    'mongo.driverOptions' => [
    ],
    //cache
    'cache.route.disable' => true,
    //fluentd
    'fluentd.address' => '',
    'fluentd.port' => '24224',
    'fluentd.tag' => '',
    //memcached
    'memcached.serevice'=>[['memcached-1',11211],['memcached-2',11211]],
    //services
    'services.backend.url' => 'http://marmot-backend-sample-code/',
    //cookie
    'cookie.domain'     => '',
    'cookie.path'       => '/',
    'cookie.duration'   => 2592000,
    'cookie.name'       => 'portal_marmot',
    'cookie.encrypt.key' => 'marmot',
    //services
    'services.api.url' => 'http://47.96.150.169:8000/',
    'services.demo.url' => 'http://47.96.150.169:8080/',
];
