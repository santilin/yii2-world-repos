<?php
/*<<<<<USES*/
/*Template:Yii2App/layouts/login.php*/
/**
 * Yii2App Bootstrap4 'login' layout
 * @var \yii\web\View $this
 * @var string $content
*/

use yii\helpers\{Html,Url};
use yii\bootstrap4\Breadcrumbs;
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
?>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
<?php
/*>>>>>BEGINPAGE*/
/*<<<<<BEGINBODY*/
?>
</head>
<?php $this->beginBody() ?>
<body class="site" data-bs-theme="light">
<header aria-hidden=true>
<?php
/*>>>>>BEGINBODY*/
/*<<<<<BREADCRUMBS*/
	echo Breadcrumbs::widget([
		'homeLink' => [ 'label' => Yii::t('app', 'World repositories'), 'url' => ['/']],
		'links' => $this->params['breadcrumbs']?? [ 'Inicio' ],
		'options' => ['class' => 'breadcrumb justify-content-center'] ]);
?>
<h1 class=text-center><?= (isset(Yii::$app->params['logo']) ? Html::img(Yii::$app->params['logo'], ['id' => 'app-logo']) : '') . '<br>' . Yii::$app->name ?></h1>
</header>
<main aria-label="contenido">
<?php
/*>>>>>BREADCRUMBS*/
/*<<<<<CONTENT*/
echo SessionAlert::widget();
?>
<?php
echo str_replace('<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">',
				 '<div class="col-md-4 offset-md-4 col-sm-6 offset-sm-3">', $content);
/*>>>>>CONTENT*/
/*<<<<<ENDBODY*/
?>
</main>
<footer aria-hidden=true>
<?php
/*>>>>>ENDBODY*/
/*<<<<<FOOTER*/
?>
	<div class="container">
		<p class="float-sm-left">&copy; <?= $company ?>, <?= date('Y') ?></p>
		<p class="float-sm-right"><?= $created_by ?></p>
	</div>
</footer>
<?=	$this->endBody(); ?>
</body>
</html>
<?php
$this->endPage();
/*>>>>>FOOTER*/
