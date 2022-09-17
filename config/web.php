<?php
/*<<<<<CONFIG*/
$params = require __DIR__ . '/params.php';
if( file_exists(__DIR__ . "/local_params.php") ) {
	$params = array_merge($params, require( __DIR__ ."/local_params.php"));
}
$smtp_transport = require __DIR__ . '/smtp.php';
$db = require __DIR__ . '/db.php';
$i18n = require __DIR__ . '/i18n.php';
$routes = require __DIR__ . '/routes.php';
$secrets = require __DIR__ . '/secrets.php';

$config = [
	'id' => 'world-repos',
	'name' => 'World repositories',
	'basePath' => dirname(__DIR__),
	'vendorPath' => '/home/santilin/devel/yii2base/vendor/santilin/yii2-world-repos/vendor/',
	// Set as es-ES, not es_ES
	'language' => 'es-ES',
	'sourceLanguage' => 'es',
	'bootstrap' => ['log'],
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
		'request' => [
			// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
			'cookieValidationKey' => $secrets['cookie_validation_key'],
			'parsers' => [
				'application/json' => 'yii\web\JsonParser',
			]
		],
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'errorHandler' => [
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
			'datetimeFormat' => 'php:d/m/Y h:i:s',
			'currencyCode' => 'EUR',
		],
		'db' => $db,
		'i18n' => $i18n,
		'urlManager' => [
			'class' => 'yii\web\UrlManager',
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' => $routes,
		],
		'mailer' =>	[
			'class' => 'yii\swiftmailer\Mailer',
			'viewPath' => '@app/views/mailer',
			'transport' => $smtp_transport
		]
	],
	'params' => $params,
];
/*>>>>>CONFIG*/
/*<<<<<DEBUG*/
if (YII_ENV_DEV || YII_ENV_TEST) {
	Yii::setAlias('@tests', dirname(__DIR__) . '/tests');
}
if (YII_ENV_DEV) {
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
// $config['modules']['gridview']['downloadAction'] = 'gridview/export/download';
// $config['modules']['gridview']['i18n'] = [];
/*<<<<<MODULE_DATECONTROL*/
// https://github.com/kartik-v/yii2-datecontrol/issues/17
$config['modules']['datecontrol'] = [
	'class' => 'kartik\datecontrol\Module',

	// format settings for displaying each date attribute
	'displaySettings' => [
		\kartik\datecontrol\Module::FORMAT_DATE => 'php:d/m/Y',
		\kartik\datecontrol\Module::FORMAT_TIME => 'php:H:m:s a',
		\kartik\datecontrol\Module::FORMAT_DATETIME => 'php:d/m/Y H:i:s',
	],

	// format settings for saving each date attribute
	'saveSettings' => [
		\kartik\datecontrol\Module::FORMAT_DATE => 'php:Y-m-d',
		\kartik\datecontrol\Module::FORMAT_TIME => 'php:H:i:s',
		\kartik\datecontrol\Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
	],

	// set your display timezone
	'displayTimezone' => 'UTC',

	// set your timezone for date saved to db
	'saveTimezone' => 'UTC',

	// automatically use kartik\widgets for each of the above formats
	'autoWidget' => true,

	// use ajax conversion for processing dates from display format to save format.
	'ajaxConversion' => true,

	// default settings for each widget from kartik\widgets used when autoWidget is true
	'autoWidgetSettings' => [
		\kartik\datecontrol\Module::FORMAT_DATE => [
			'type'=>2,
			'pluginOptions'=> [
				'autoclose'=>true,
				'weekStart' => 1,
			]
		],
		\kartik\datecontrol\Module::FORMAT_DATETIME => [
			'pluginOptions'=> [
				'autoclose'=>true,
				'weekStart' => 1,
			]
		], // setup if needed
		\kartik\datecontrol\Module::FORMAT_TIME => [], // setup if needed
	],

	// custom widget settings that will be used to render the date input instead of kartik\widgets,
	// this will be used when autoWidget is set to false at module or widget level.
	'widgetSettings' => [
		\kartik\datecontrol\Module::FORMAT_DATE => [
			'class' => 'yii\jui\DatePicker', // example
			'options' => [
				'dateFormat' => 'php:d-M-Y',
				'options' => ['class'=>'form-control'],
			]
		]
	]
];
/*>>>>>MODULE_DATECONTROL*/
// tweak your DateControl settings here
// $config['modules']['datecontrol'][...] = ...

// You can tweak the $config array here as you need
/*<<<<<RETURN*/
unset($params, $smtp_transport, $db, $i18n, $routes, $secrets);
if( file_exists(__DIR__ . "/local_web.php") ) {
	return yii\helpers\ArrayHelper::merge($config, require( __DIR__ ."/local_web.php"));
} else {
	return $config;
}
/*>>>>>RETURN*/

