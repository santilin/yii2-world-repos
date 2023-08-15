<?php
/*<<<<<CONFIG*/
$config = require __DIR__ . '/web.php';
$config['components']['db'] = require __DIR__ . '/test_db.php';
$config['id'] = $config['id'] . "_tests";
$config['name'] = $config['name'] . "_tests";
$config['components']['mailer']['useFileTransport'] = true;
/*>>>>>CONFIG*/
/*<<<<<return*/
return $config;
/*>>>>>return*/
