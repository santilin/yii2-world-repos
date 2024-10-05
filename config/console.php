<?php
/*<<<<<CONFIG*/
$local_config = require __DIR__ . '/local_config.php';
$config = [
    'id' => 'world-repos',
	'name' => 'World repositories',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
	// Set as es-ES, not es_ES
	'language' => 'es-ES',
	'sourceLanguage' => 'es',
	'vendorPath' => dirname(__DIR__) . '/vendor/',
    'controllerNamespace' => 'santilin\wrepos\console\controllers',
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
			'locale' => 'es_ES', 'dateFormat' => 'php:d/m/Y', 'datetimeFormat' => 'php:d/m/Y H:i:s'
		],
		'db' => $local_config['dbs'][0],
		'i18n' => require __DIR__ . '/i18n.php',
		'mailer' => $local_config['mailers'][0],
		'urlManager' => [
            'class' => 'yii\web\UrlManager',
			'baseurl' => YII_ENV_PROD ? 'undefined' : 'http://world-repos.test',
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'hostinfo' => YII_ENV_PROD ? 'undefined' : 'http://world-repos.test',
        ],
    ],
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => '@app/database/migrations',
		]
    ],
	'params' => require __DIR__ . '/params.php',
];
/*>>>>>CONFIG*/
/*<<<<<DEBUG*/
if (YII_ENV_DEV || YII_ENV_TEST) {
	global $global_fixtures_suite;
	if (!isset($global_fixtures_suite)) {
		$global_fixtures_namespace = '';
		$global_fixtures_suite = '';
	} else {
		$global_fixtures_namespace = "\\$global_fixtures_suite";
		$global_fixtures_suite = "/$global_fixtures_suite";
	}
	Yii::setAlias('@tests', dirname(__DIR__) . '/tests');
	$config['controllerMap']['fixture'] = [ // Fixture generation command line.
		'class' => 'yii\faker\FixtureController',
		// paths and namespaces by default for the unit suite
		'templatePath' => "@tests$global_fixtures_suite/fixtures/faker",
		'namespace' => "tests$global_fixtures_namespace\\fixtures",
		'fixtureDataPath' => "@tests$global_fixtures_suite/fixtures/data", // for faker
		'providers' => [
			'santilin\churros\fakers\Base',
			'santilin\churros\fakers\Address',
			'santilin\churros\fakers\Person',
			'santilin\churros\fakers\PhoneNumber',
		],
	];
}
// if (YII_ENV_DEV) {
// 	$config['components']['log']['targets'][] = [
//         'class' => 'yii\log\FileTarget',
//         'logFile' => '@runtime/logs/profile.log',
//         'logVars' => [],
//         'levels' => ['profile'],
//         'categories' => ['yii\db\Command::query', 'yii\db\Command::execute'],
//         'prefix' => function($message) {
//             return 'db:';
//         }
//     ];
// }
/*>>>>>DEBUG*/
// You can tweak the $config array here as you need
/*<<<<<RETURN*/
if( file_exists(__DIR__ . "/local_console.php") ) {
	$config = yii\helpers\ArrayHelper::merge($config, require( __DIR__ ."/local_console.php"));
}
unset($local_config);
return $config;
/*>>>>>RETURN*/
