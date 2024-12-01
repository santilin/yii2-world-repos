<?php
/*<<<<<CONFIG*/
$web_app = false;
$config = [
    'id' => 'world-repos',
	'name' => 'World repositories',
    'basePath' => dirname(__DIR__),
	'vendorPath' => dirname(__DIR__) . '/vendor/',
    'language' => 'es-ES', // Set as es-ES, not es_ES
	'sourceLanguage' => 'es',
	'bootstrap' => ['log'],
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
			// 'dateFormat' => '%d/%m/%y',
			// 'dateTimeFormat' => '%a %d %b %Y %T',
			// 'currencyCode' => '€',
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
				'dsn' => "smtp://smtp_username:smtp_password@smtp_host:smtp_port?encryption=smtp_encryption"
			]
		],
		'urlManager' => [ // for testing mainly
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
	global $global_fixtures_suite;
	if (!isset($global_fixtures_suite)) {
		$global_fixtures_namespace = '';
		$global_fixtures_suite = '';
	} else {
		$global_fixtures_namespace = "\\$global_fixtures_suite";
		$global_fixtures_suite = "/$global_fixtures_suite";
	}
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
/*>>>>>DEBUG*/
// You can tweak the $config array here as you need
/*<<<<<RETURN*/
require __DIR__ . '/local_config.php';
return $config;
/*>>>>>RETURN*/
