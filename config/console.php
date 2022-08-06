<?php
/*<<<<<CONFIG*/
$params = require __DIR__ . '/params.php';
if( file_exists(__DIR__ . "/local_params.php") ) {
	$params = array_merge($params, require( __DIR__ ."/local_params.php"));
}
$db = require __DIR__ . '/db.php';
$smtp_transport = require __DIR__ . '/smtp.php';
$i18n = require __DIR__ . '/i18n.php';

$config = [
    'id' => 'basic-console',
	'name' => 'World repositories',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
	// Set as es-ES, not es_ES
	'language' => 'es-ES',
	'sourceLanguage' => 'es',
	'vendorPath' => '/home/santilin/devel/yii2base/yii2-world-repositories/vendor/',
    'controllerNamespace' => 'app\console\controllers',
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
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
		'formatter' => [
			'locale' => 'es_ES', 'dateFormat' => 'php:d/m/Y', 'datetimeFormat' => 'php:d/m/Y h:i:s'
		],
        'db' => $db,
        'i18n' => $i18n,
		'mailer' => [
			'useFileTransport' => YII_ENV_DEV, // Avoid email errors in development env
			'class' => 'yii\swiftmailer\Mailer',
			'viewPath' => '@app/views/mailer',
			'transport' => $smtp_transport
		],
    ],
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => '@app/database/migrations',
		]
    ],
	'params' => $params,
];
/*>>>>>CONFIG*/
/*<<<<<DEBUG*/
if (YII_ENV_DEV || YII_ENV_TEST) {
	Yii::setAlias('@tests', dirname(__DIR__) . '/tests');
	$config['controllerMap']['fixture'] = [ // Fixture generation command line.
		'class' => 'yii\faker\FixtureController',
		'templatePath' => '@tests/fixtures/templates',
		'namespace' => 'tests\fixtures\unit',
		'fixtureDataPath' => '@tests/fixtures/unit/data', // for faker
		'providers' => [
				'santilin\churros\fakers\Base',
				'santilin\churros\fakers\Address',
				'santilin\churros\fakers\Person',
				'santilin\churros\fakers\PhoneNumber',
		],
	];
}
if (YII_ENV_DEV) {
	$config['components']['log']['targets'][] = [
        'class' => 'yii\log\FileTarget',
        'logFile' => '@runtime/logs/profile.log',
        'logVars' => [],
        'levels' => ['profile'],
        'categories' => ['yii\db\Command::query', 'yii\db\Command::execute'],
        'prefix' => function($message) {
            return 'db:';
        }
    ];
}
/*>>>>>DEBUG*/
// You can tweak the $config array here as you need
/*<<<<<RETURN*/
unset($params, $smtp_transport, $db, $i18n);
if( file_exists(__DIR__ . "/local_console.php") ) {
	return yii\helpers\ArrayHelper::merge($config, require( __DIR__ ."/local_console.php"));
} else {
	return $config;
}
/*>>>>>RETURN*/
