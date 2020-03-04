<?php
/**
 * \d+(,\d+)*
 * 路由设置
 */

return [
        //监控检测
        [
            'method'=>'GET',
            'rule'=>'/healthz',
            'controller'=>[
                'Home\Controller\HealthzController',
                'healthz'
            ]
        ],
    ];
