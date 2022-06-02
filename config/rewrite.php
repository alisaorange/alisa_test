<?php
return [
    // backend
    'admin' =>  'admin/settings',
    'admin-login' =>  'admin/user/admin-login',
    'admin/<controller:\w+>/<id:\d+>' => 'admin/<controller>/view',
    'admin/<controller:\w+>/<action:\w+>/<id:\d+>' => 'admin/<controller>/<action>',
    'admin/<controller:\w+>/<action:\w+>' => 'admin/<controller>/<action>',


    //frontend
    '/' => 'site/index',
    'index' => 'site/index',
    'login' => 'site/login',
    'search' => 'site/search',
    'super' => 'site/super',
    'category/<slug:\S+>' => 'category/view',
    'book/<slug:\S+>' => 'book/view',

];