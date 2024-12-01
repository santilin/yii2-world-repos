<?php
/*<<<<<CONFIG*/
$web_app = true;
$config = [
	'id' => 'world-repos',
	'name' => 'World repositories',
	'basePath' => dirname(__DIR__),
	'vendorPath' => dirname(__DIR__) . '/vendor/',
	'language' => 'es-ES', // Set as es-ES, not es_ES
	'sourceLanguage' => 'es',
	'bootstrap' => ['log'],
	'controllerNamespace' => 'santilin\wrepos\controllers',
	'modules' => [
		'churros' => [
			'class' => 'santilin\churros\Module'
		]
	],
	'components' => [
		'cache' => [
			'class' => 'yii\caching\FileCache',
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
			'locale' => 'es-ES',
			// 'dateFormat' => ''%d/%m/%y'',
			// 'dateTimeFormat' => ''%a %d %b %Y %T'',
			// 'currencyCode' => ''€'',
		],
		'db' => [
			'class' => 'yii\db\Connection',
			'charset' => 'utf8mb4',
			'enableSchemaCache' => YII_ENV_PROD,
			'schemaCacheDuration' => 6000,
			'schemaCache' => 'cache',
		],
		'i18n' => [
			'translations' => [
				'app*' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => '@app/messages',
				],
			]
		],
		'mailer' => [
			'useFileTransport' => false,
			'class' => 'yii\symfonymailer\Mailer',
			'viewPath' => '@app/views/mails',
			'transport' => 	[
				'dsn' => "smtp://username:password@host:port?encryption=encryption"
			]
		],
		'urlManager' => [
			'class' => 'yii\web\UrlManager',
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' => require __DIR__ . '/routes.php',
		],
		'assetManager' => [
			'linkAssets' => YII_ENV_DEV,
			'forceCopy' => YII_ENV_DEV
		],
		'request' => [
			'cookieValidationKey' => 'ëµÕ°0sFºfCX2;TeôûFùýÐ²áFCB& zžþ',
			'parsers' => [
				'application/json' => 'yii\web\JsonParser',
			]
		],
		'errorHandler' => [
			'class' => \santilin\churros\components\ErrorHandler::class,
			'errorAction' => 'site/error',
		],
	],
	'aliases' => [
		'@bower' => '@vendor/bower-asset',
		'@npm'   => '@vendor/npm-asset',
		'@tests' => '@app/tests',
	],
	'params' => require __DIR__ . '/params.php',
];
require __DIR__ . '/components.php';
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
require __DIR__ . '/local_config.php';
return $config;
/*>>>>>RETURN*/
