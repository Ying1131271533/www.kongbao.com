<?php

use think\facade\Env;

return [
    'default' => Env::get('filesystem.driver', 'local'),
    'disks'   => [
        'local'  => [
            'type' => 'local',
            'root' => app()->getRuntimePath() . 'static/upload',
        ],
        'public' => [
            'type'       => 'local',
            'root'       => app()->getRootPath() . 'public/static/upload',
            'url'        => '/static/upload',
            'visibility' => 'public',
        ],
        // 更多的磁盘配置信息
    ],
];
