<?php
/*<<<<<MAIN*/
/*Template:Yii2App/config/components.php*/
// Optional components common to console and web applications
global $config, $web_app;
/*>>>>>MAIN*/
/*<<<<<MODULE_GRIDVIEW*/
$config['modules']['gridview'] =  [
	'class' => '\kartik\grid\Module',
	// enter optional module parameters below - only if you need to
	// use your own export download action or custom translation
	// message source. See http://demos.krajee.com/grid
];
/*>>>>>MODULE_GRIDVIEW*/
// $config['modules']['gridview']['downloadAction'] = 'gridview/export/download';
// $config['modules']['gridview']['i18n'] = [];
