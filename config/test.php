<?php
/*<<<<<CONFIG*/
if (defined('TESTING_COMMAND')) {
	$config = require __DIR__ . '/console.php';
} else {
	$config = require __DIR__ . '/web.php';
}
$config['id'] = $config['id'] . "_tests";
$config['name'] = $config['name'] . "_tests";
$config['components']['db']['dsn'] = 'sqlite:@app/runtime/test/world-repos.db';
/*>>>>>CONFIG*/
/*<<<<<return*/
return $config;
/*>>>>>return*/
