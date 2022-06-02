<?php
$dir_separator = DIRECTORY_SEPARATOR;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@webroot'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'admin' => [
            'class' => 'app\backend\AdminModule',
            'layout' => 'main',
        ],
//        'settings' => [
//            'class' => 'yii2mod\settings\Module',
//        ],
    ],
//    'controllerMap' => [
//        'elfinder' => [
//            'class' => 'mihaildev\elfinder\Controller',
//            'access' => ['@'], //глобальный доступ к фаил менеджеру @ - для авторизорованных , ? - для гостей , чтоб открыть всем ['@', '?']
//            'roots' => [
//                [
//                    'baseUrl'=>'@web',
//                    'basePath'=>'@webroot',
//                    'path' => 'uploads/images',
//                    'name' => 'Resource'
//                ],
//            ],
//        ]
//    ],
    'components' => [
        'i18n' => [
            'translations' => [
                'yii2mod.settings' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/settings/messages',
                ],
                // ...
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
                ],
            ],
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'CKDoM0WLwBxEKuD5hQsEhYJYQOLNwcT9',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => function () {
            return Yii::createObject([
                'class' => 'yii\swiftmailer\Mailer',
                'transport' => [
                    'class' => 'Swift_SmtpTransport',
                    'host' => Yii::$app->settings->get('SiteSetting', 'smtpHost'),
                    'port' => Yii::$app->settings->get('SiteSetting', 'smtpPort'),
                    'username' => Yii::$app->settings->get('SiteSetting', 'smtpUsername'),
                    'password' => Yii::$app->settings->get('SiteSetting', 'smtpPassword'),
                    'encryption' => Yii::$app->settings->get('SiteSetting', 'smtpSecure'),
                ],
            ]);
        },
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => file_exists(__DIR__ . $dir_separator . 'rewrite.php') ? require_once(__DIR__ . $dir_separator . 'rewrite.php') : [],
        ],
        'settings' => [
            'class' => 'yii2mod\settings\components\Settings',
        ],
        'thumbnail' => [
            'class' => 'himiklab\thumbnail\EasyThumbnail',
            'cacheAlias' => 'assets/gallery_thumbnails',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
