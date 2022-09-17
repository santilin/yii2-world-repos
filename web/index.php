<?php
/*<<<<<MAIN*/
// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require '/home/santilin/devel/yii2base/vendor/santilin/yii2-world-repos/vendor/autoload.php';
require '/home/santilin/devel/yii2base/vendor/santilin/yii2-world-repos/vendor/yiisoft/yii2/Yii.php';

define('APP_VERSION','0.0.1');

$config = require __DIR__ . '/../config/web.php';
/*>>>>>MAIN*/
/*<<<<<RUN*/
(new yii\web\Application($config))->run();
/*>>>>>RUN*/
