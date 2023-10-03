<?php
/*<<<<<CONFIG*/
$db_params = [
    'class' => 'yii\db\Connection',
    'charset' => 'utf8',
    // Schema cache options (for production environment)
    'enableSchemaCache' => YII_ENV_PROD,
    'schemaCacheDuration' => 60,
    'schemaCache' => 'cache',
];
/*>>>>>CONFIG*/
// $db_params['dsn'] = 'mysql:host=localhost;dbname=world-repositories_db';
$db_params['dsn'] = 'sqlite:@app/runtime/repos.db';
/*<<<<<RETURN*/
return $db_params;
/*>>>>>RETURN*/

