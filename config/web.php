<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'sg0Wrpy-36bg6iRtVXdbDi1Odfm4oBJ8',
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
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',  
                'host' => 'localhost',
                'username' => $app->params['alertsEmail'],
                'password' => '#Happiness99',
                'port' => '465',
                'encryption' => 'ssl',
//                'host' => 'smtp.gmail.com',
//                'username' => 'testsk1988@gmail.com',
//                'password' => 'testlogin@123',
//                'port' => '587',
//                'encryption' => 'tls',
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller>/<action>' => '<controller>/<action>',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '' => 'site/index',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'bundles' => [
                        'yii\web\JqueryAsset' => [
                            'jsOptions' => ['position' => 1],
                            'js' => [
                                YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js'
                            ]
                        ],
                        'yii\bootstrap\BootstrapAsset' => [
                            'css' => [
                                YII_ENV_DEV ? 'css/bootstrap.css' :         'css/bootstrap.min.css',
                            ]
                        ],
                        'yii\bootstrap\BootstrapPluginAsset' => [
                            'js' => [
                                YII_ENV_DEV ? 'js/bootstrap.js' : 'js/bootstrap.min.js',
                            ]
                        ]
            ],
        ],
        //
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
