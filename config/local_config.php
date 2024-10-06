<?php
$smtp_host = '';
$smtp_username = '';
$smtp_password = '';
$smtp_port = 587;
$smtp_encryption = 'tls'; // tls | ssl

$db_driver = 'sqlite';
$db_database = '@app/runtime/wrepos.db';
$db_username = '';
$db_password = '';
$db_host = '';

$ret = [
	'dbs' => [
		[
			'class' => 'yii\db\Connection',
			'charset' => 'utf8mb4',
			// Schema cache options (for production environment)
			'enableSchemaCache' => YII_ENV_PROD,
			'schemaCacheDuration' => 60,
			'schemaCache' => 'cache',
			'dsn' => "$db_driver:$db_database",
			'username' => $db_username,
			'password' => $db_password,
		]
	],
	'mailers' => [
		[
			'useFileTransport' => false,
			'class' => 'yii\symfonymailer\Mailer',
			'viewPath' => '@app/views/mails',
			'transport' => 	[
				'dsn' => "smtp://$smtp_username:$smtp_password@$smtp_host:$smtp_port?encryption=$smtp_encryption"
			]
		]
	],
	'secrets' => require __DIR__ .'/secrets.php',
];

unset($smtp_username,$smtp_password,$smtp_host,$smtp_port,$smtp_encryption,$db_username,$db_password,$db_database,$db_host);

return $ret;

