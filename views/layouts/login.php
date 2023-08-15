<?php
/*<<<<<USES*/
/*Template:Yii2App/layouts/login.php*/
/* @var \yii\web\View $this*/
/* @var string $content */

use yii\helpers\{Html,Url};
use yii\widgets\Breadcrumbs;
use app\assets\LoginAsset;
use santilin\churros\helpers\AppHelper;
use santilin\churros\widgets\SessionAlert;

LoginAsset::register($this);
$company = $brand_name = Yii::$app->name;
$created_by = 'Creado por Santilín con Yii' . Yii::getVersion();
/*>>>>>USES*/
/*<<<<<BEGINPAGE*/
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta name="description" content="world-repos">
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
<?php $this->beginBody() ?>
<body class="site">
<div class="header">
<div class="text-center">
<?php
/*>>>>>BEGINBODY*/
/*<<<<<JUMBOTRON*/
	echo Breadcrumbs::widget([
		'homeLink' => [ 'label' => Yii::t('app', 'World repositories'), 'url' => ['/']],
		'links' => $this->params['breadcrumbs']?? [ 'Inicio' ] ]); ?>
	<h1><?= (isset(Yii::$app->params['logo']) ? Html::a(Html::img(Yii::$app->params['logo'], ['id' => 'app-logo']), ['/']) : '') . '&nbsp;&nbsp;' . Yii::$app->name ?></h1>
</div><!--jumbotron-->
<?php
/*>>>>>JUMBOTRON*/
/*<<<<<CONTENT*/
echo SessionAlert::widget();
echo $content;
/*>>>>>CONTENT*/
/*<<<<<ENDBODY*/
?>
</div>
</div>
<footer class="footer">
<?php
/*>>>>>ENDBODY*/
/*<<<<<FOOTER*/
?>
	<div class="container">
		<p class="pull-left">&copy; <?= $company ?>, <?= date('Y') ?></p>
		<p class="pull-right"><?= $created_by ?></p>
	</div>
</footer>
<?=	$this->endBody(); ?>
</body>
</html>
<?php
$this->endPage();
/*>>>>>FOOTER*/
