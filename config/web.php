<?php
/*<<<<<CONFIG*/
$local_config = require __DIR__ . '/local_config.php';
$config = [
	'id' => 'world-repos',
	'catchAll' => ($params['maintenance']??null)?['site/maintenance', 'message' => $params['maintenance']]:'',
	'name' => 'World repositories',
	'basePath' => dirname(__DIR__),
	'vendorPath' => dirname(__DIR__) . '/vendor/',
	// Set as es-ES, not es_ES
	'language' => 'es-ES',
	'sourceLanguage' => 'es',
	'bootstrap' => ['log'],
	'controllerNamespace' => 'santilin\wrepos\controllers',
	'aliases' => [
		'@bower' => '@vendor/bower-asset',
		'@npm'   => '@vendor/npm-asset',
		'@tests' => '@app/tests',
	],
	'modules' => [
		'churros' => [
			'class' => 'santilin\churros\Module'
		]
	],
	'components' => [
		'assetManager' => [
			'linkAssets' => YII_ENV_DEV,
			'forceCopy' => YII_ENV_DEV
		],
		'request' => [
			// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
			'cookieValidationKey' => $local_config['secrets']['cookie_validation_key'],
			'parsers' => [
				'application/json' => 'yii\web\JsonParser',
			]
		],
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'errorHandler' => [
			'class' => \santilin\churros\components\ErrorHandler::class,
			'errorAction' => 'site/error',
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
		'formatter' => [
			'class' => \santilin\churros\components\Formatter::class,
			'locale' => 'es_ES',
			'dateFormat' => 'php:d/m/Y',
			'datetimeFormat' => 'php:d/m/Y H:i:s',
			'currencyCode' => 'EUR',
		],
		'db' => $local_config['dbs'][0],
		'i18n' => require __DIR__ . '/i18n.php',
		'mailer' => $local_config['mailers'][0],
		'urlManager' => [
			'class' => 'yii\web\UrlManager',
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' => require __DIR__ . '/routes.php',
		],
	],
	'params' => require __DIR__ . '/params.php',
];
/*>>>>>CONFIG*/
/*<<<<<DEBUG*/
if (YII_ENV_DEV || YII_ENV_TEST) {
	Yii::setAlias('@tests', dirname(__DIR__) . '/tests');
}
if (YII_ENV_DEV && YII_DEBUG) {
	$config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
            'class' => 'yii\debug\Module',
            // uncomment and adjust the following to add your IP if you are not connecting from localhost.
            //'allowedIPs' => ['127.0.0.1', '::1'],
	];
}
/*>>>>>DEBUG*/
/*<<<<<MODULE_GRIDVIEW*/
$config['modules']['gridview'] =  [
	'class' => '\kartik\grid\Module'
	// enter optional module parameters below - only if you need to
	// use your own export download action or custom translation
	// message source. See http://demos.krajee.com/grid
];
/*>>>>>MODULE_GRIDVIEW*/
/*<<<<<WEBUSERS_NOUSERS*/
\yii\base\Event::on(\yii\web\Application::className(), \yii\web\Application::EVENT_BEFORE_REQUEST, function ($event) {
	$event->sender->clear('user');
});
/*>>>>>WEBUSERS_NOUSERS*/
// $config['modules']['gridview']['downloadAction'] = 'gridview/export/download';
// $config['modules']['gridview']['i18n'] = [];


// You can tweak the $config array here as you need
/*<<<<<RETURN*/
if( file_exists(__DIR__ . "/local_web.php") ) {
	$config = yii\helpers\ArrayHelper::merge($config, require( __DIR__ ."/local_web.php"));
}
unset($local_config);
return $config;
/*>>>>>RETURN*/
