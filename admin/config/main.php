<?php
$params = array_merge(
require(__DIR__ . '/../../common/config/params.php'),
require(__DIR__ . '/../../common/config/params-local.php'),
require(__DIR__ . '/params.php')
);
return [
'id' => 'app-admin',
'basePath' => dirname(__DIR__),
'controllerNamespace' => 'admin\controllers',
'bootstrap' => ['log'],
'modules' => [],
'components' => [

	'request' => [
	'parsers' => [
	'application/json' => 'yii\web\JsonParser',
	]
	],



	'urlManager' => [
		'class' => 'yii\web\UrlManager',
		'enablePrettyUrl' => true,
		'showScriptName' => false,
		//'suffix' => '.json',
		//'enableStrictParsing' => true,

		//'prefix' => 'api',
		'rules' => [ 
			//'<controller:\w+>/<id:\d+>' => '<controller>/view',
			//'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
/*
			[
				'class' => 'yii\web\GroupUrlRule',
                'prefix' => 'api',
				'rules' => [
					'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
				]

			]
*/
			'api/<controller:\w+>/<action:\w+>' => '<controller>/<action>',
			'api/<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',

			//'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
			//'category/<url:>' => 'category/view',
		],


	],
	'user' => [
	'identityClass' => '\common\models\User',
	'enableSession' => false,
	'loginUrl' => null
	],
	'log' => [
		'traceLevel' => YII_DEBUG ? 3 : 0,
		'targets' => [
			[
				'class' => 'yii\log\FileTarget',
				'levels' => ['error', 'warning'],
			],
			[
				'class' => 'yii\log\FileTarget',
				'categories' => ['debug'],
				'logFile' => '@app/runtime/logs/debug.log',
			],
		],
	],
],
'params' => $params,


];


