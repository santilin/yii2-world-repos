<?php
/*<<<<<BASIC*/
$routes = [
/*>>>>>BASIC*/
/*<<<<<MAIN_ROUTES*/
	// HasMany routes
	'<parent_controller:[A-Za-z0-9_\-]+>/<parent_id:\d+>/<controller:[A-Za-z0-9_\-]+>/<id:\d+>' => '<controller>/view',
	'<parent_controller:[A-Za-z0-9_\-]+>/<parent_id:\d+>/<controller:[A-Za-z0-9_\-]+>/<action:[A-Za-z0-9_\-]+>/<id:\d+>' => '<controller>/<action>',
	'<parent_controller:[A-Za-z0-9_\-]+>/<parent_id:\d+>/<controller:[A-Za-z0-9_\-]+>/<action:[A-Za-z0-9_\-]+>' => '<controller>/<action>',
	// Default routes
	'<controller:[A-Za-z0-9_\-]+>/<id:\d+>' => '<controller>/view',
	'<controller:[A-Za-z0-9_\-]+>/<action:[A-Za-z0-9_\-]+>/<id:\d+>' => '<controller>/<action>',
	'<controller:[A-Za-z0-9_\-]+>/<action:[A-Za-z0-9_\-]+>' => '<controller>/<action>',
/*>>>>>MAIN_ROUTES*/
/*<<<<<END*/
];
return $routes;
/*>>>>>END*/
