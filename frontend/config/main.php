<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
		'log',
		//'cms'
	],
    'controllerNamespace' => 'frontend\controllers',
	'defaultRoute' => 'cms/index',
    'components' => [

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                // ...
				//'/' =>  'cms/index',
				'<lang:\w+>' => 'cms/index',
				'<lang:\w+>/page/<page_id:\d+>' => 'cms/page',
            ],
        ],

        //'user' => [
        //    'identityClass' => 'common\models\User',
        //    'enableAutoLogin' => true,
        //],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
		//'menu' =>
    ],
    'params' => $params,
];
