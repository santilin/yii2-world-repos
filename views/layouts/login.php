<?php
/*<<<<<USES*/
/* @var \yii\web\View $this*/
/* @var string $content */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\LoginAsset;
use santilin\churros\helpers\AppHelper;
use santilin\churros\yii\bootstrap\SessionAlert;

LoginAsset::register($this);
$company = Yii::$app->name;
/*>>>>>USES*/
/*<<<<<BEGINPAGE*/
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta name="description" content="world-repositories">
	<meta name="author" content="santilín">
	<meta charset="<?= Yii::$app->charset ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
echo $this->registerCsrfMetaTags();
if( !YII_ENV_DEV && AppHelper::yiiparam('baseUrl') ) {
	echo '<base href="' . AppHelper::yiiparam('baseUrl') . "\">\n";
}
?>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
<?php
/*>>>>>BEGINPAGE*/
/*<<<<<BEGINBODY*/
?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="text-center">
<?php
/*>>>>>BEGINBODY*/
/*<<<<<JUMBOTRON*/
	echo Breadcrumbs::widget([
		'homeLink' => [ 'label' => Yii::t('app', 'Inicio'), 'url' => ['/']],
		'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
	]) ?>
	<h1><?= (isset(Yii::$app->params['logo']) ? Html::img(Yii::$app->params['logo'], ['id' => 'app-logo']) : '') . Yii::$app->name ?></h1>
</div><!--jumbotron-->
<?php
/*>>>>>JUMBOTRON*/
/*<<<<<CONTENT*/
echo SessionAlert::widget();
echo $content;
/*>>>>>CONTENT*/
/*<<<<<ENDBODY*/
?>
<footer class="footer">
<?php
/*>>>>>ENDBODY*/
/*<<<<<FOOTER*/
?>
	<div class="container">
		<p class="pull-left">&copy; <?= $company ?> <?= date('Y') ?></p>
		<p class="pull-right">Desarrollado por Santilín con Yii2</p>
	</div>
</footer>
<?=	$this->endBody(); ?>
</body>
</html>
<?php
$this->endPage();
/*>>>>>FOOTER*/
