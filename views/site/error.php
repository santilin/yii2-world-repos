<?php
/*<<<<<USES*/
/* var yii\web\View $this */
/* @var $name string */
/* @var $message string */
/* @var Exception $exception */

use yii\helpers\{Html,StringHelper,Url};
use santilin\churros\helpers\{AppHelper,FormHelper};
use app\helpers\UserHelper;
use yii\web\HttpException;

$referrer = $_SERVER['HTTP_REFERER']??null;
$module_id = Yii::$app->controller->module?->id;
$access_exception = false;
if ($exception && $exception instanceof HttpException) {
	if ($exception->statusCode == 403) {
		$access_exception = true;
		if (!$name) {
			$name = 'Acceso denegado';
		}
	}
}
$this->title = $name??'Error';
?>

<div class="alert alert-danger">

	<div class="site-error">

	<h1><?= Html::encode($this->title) ?></h1>
<?php
if ($access_exception) {
	if (UserHelper::userIsAdmin()) {
?>
		<p><?= 'Como administrador/a,'?></p>
<?php
	} else if (!Yii::$app->user?->isGuest) {
?>
		<p><?= 'Como usuario/a,'?></p>
<?php
		if ($referrer && $module_id) {
			$path = parse_url($referrer, PHP_URL_PATH)?:null;
			if ($path) {
				$path_parts = array_filter(explode('/', $path));
				$ref_module = array_shift($path_parts);
				if ($ref_module == $module_id) {
					if ($path_parts) {
						$ref_model = AppHelper::modelize(array_shift($path_parts));
						if ($ref_model) {
							echo "<p>con permisos ";
							foreach (array_keys(Yii::$app->authManager->getItems()) as $perm) {
								if (StringHelper::startsWith($perm, $module_id.'.'.$ref_model)) {
									echo $perm.', ';
								}
							}
							echo '</p>';
						}
					}
				}
			}
		}
	} else {
?>
		<p><?= 'Como invitado/a,'?></p>
<?php
	}
}
?>
<?= nl2br(Html::encode(mb_lcfirst($message))) ?>
    </div>
<?php

$buttons['retry'] = [
	'type' => 'a',
	'title' => 'Reintentar',
	'url' => 'javascript:window.location.href=window.location.href',
	'htmlOptions' => [ 'class' => 'btn btn-primary' ]
];
if (isset($_REQUEST['_form_cancelUrl'])) {
	$buttons['back'] = [
		'type' => 'a',
		'title' => 'Volver',
		'url' => $_REQUEST['_form_cancelUrl'],
		'htmlOptions' => [ 'class' => 'btn btn-primary' ],
	];
} else if (isset($_SERVER['HTTP_REFERER'])) {
	$buttons['back'] = [
		'type' => 'a',
		'title' => 'Volver',
		'url' => $_SERVER['HTTP_REFERER'],
		'htmlOptions' => [ 'class' => 'btn btn-primary' ],
	];
}
if ($module_id) {
	$buttons['home'] = [
		'type' => 'a',
		'title' => 'Inicio',
		'url' => (!$module_id || $module_id == Yii::$app->id) ? Url::home(true) : Url::home(true) . "/$module_id",
		'htmlOptions' => [ 'class' => 'btn btn-secondary' ]
	];
}
/*>>>>>USES*/
/*<<<<<BUTTONS*/
echo '<p></p>';
echo FormHelper::displayButtons($buttons);

if ((YII_ENV_TEST||YII_ENV_DEV) && isset($exception) && $exception->getPrevious()) {
?>
    <p>
        <?= Yii::$app->request->absoluteUrl ?>
    </p>
	<h2>Extended developer info</h2>
	<p><?= $exception->getPrevious()->getMessage() ?></p>
<?php
}
?>
</div>
<?php
/*>>>>>BUTTONS*/
