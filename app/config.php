<?php

return [
    'baseUrl'     => 'http://bittest.local/',

    'db' => [
        'host' => 'localhost',
        'dbname' => 'test',
        'username' => 'root',
        'password' => 'secret'
    ],

    'logger' => [
        'filePath' => 'dev.log',
    ],

    'routes' => [
        'home' => [
            'path' => '/',
            'controller' => \App\Controllers\MainController::class,
            'action' => 'indexAction'
        ],
        'login' => [
            'path' => '/login',
            'controller' => \App\Controllers\MainController::class,
            'action' => 'loginAction'
        ],
        'logout' => [
            'path' => '/logout',
            'controller' => \App\Controllers\MainController::class,
            'action' => 'logoutAction'
        ],
        'user' => [
            'path' => '/user',
            'controller' => \App\Controllers\MainController::class,
            'action' => 'userAction'
        ],
        'pay' => [
            'path' => '/pay',
            'controller' => \App\Controllers\MainController::class,
            'action' => 'payAction'
        ]
    ]
];