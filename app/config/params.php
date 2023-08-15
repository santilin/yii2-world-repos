<?php
/*<<<<<CONFIG*/
use yii\helpers\Html;
// Program parameters, not editable by the final users, example:
$ret = [
	'bsDependencyEnabled' => false,
	'bsVersion' => '4.x',
	'logo' => '/img/logo_icono.jpg',
	'adminEmail' => 'software@noviolento.es',
	'baseUrl' => 'http://noviolentismo.org',
	'develURL' => 'http://trivel.test',
	'pdfMarginBottom' => 20,
	'pdfMarginFooter' => 15,
	'pdfMarginHeader' => 15,
	'pdfMarginTop' => 20,
	'privateUploadsDir' => '@app/runtime/uploads/',
	'publicUploadsDir' => '@web/uploads/',
	'testEmail' => 'software@noviolento.es',
	'testUrl' => 'http://trivel.test',
];
// Add params here
/*>>>>>CONFIG*/
/*<<<<<RETURN*/
return $ret;
/*>>>>>RETURN*/
