<?php
/*<<<<<MAIN*/
/*Template:Yii2App/web/index.php*/
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
require dirname(__DIR__) . '/vendor/' . 'autoload.php';
require dirname(__DIR__) . '/vendor/' . 'yiisoft/yii2/Yii.php';

define('APP_VERSION','0.0.1');
define('APP_REVISION', '###GIT_REVISION###');

$config = require __DIR__ . '/../config/web.php';
/*>>>>>MAIN*/
/*<<<<<RUN*/
(new yii\web\Application($config))->run();
/*>>>>>RUN*/
