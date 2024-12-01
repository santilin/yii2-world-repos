<?php
/*<<<<<USES*/
/*Template:Yii2App/layouts/login.php*/
/**
 * Yii2App Bootstrap5 'login' layout
 * @var \yii\web\View $this
 * @var string $content
 */
use yii\helpers\{Html,Url};
use app\assets\LoginAsset;
use santilin\churros\widgets\SessionAlert;

LoginAsset::register($this);
$company = $brand_name = Yii::$app->name;
$copyright_symbol = '&copy;';
$created_by = 'Creado por Santilín con Yii' . Yii::getVersion();
/*>>>>>USES*/
/*<<<<<BEGINPAGE*/
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class='h-100' data-bs-theme="auto">
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta name="description" content="World repositories">
	<meta name="author" content="Santilín">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
echo $this->registerCsrfMetaTags();
?>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
<?php
/*>>>>>BEGINPAGE*/
/*<<<<<BODY*/
?>
</head>
<?php $this->beginBody() ?>
<body class="site">
<header class=container aria-label="navegación">
<?php
/*>>>>>BODY*/
/*<<<<<BREADCRUMBS*/
// No breadcrumbs needed here
?>
</header>
<main class=container aria-label="Contenido">
<div class="row mt-5">
<h1 class="offset-3 col-6 text-center welcome">Bienvenido a world-repos</h1>
<?php
/*>>>>>BREADCRUMBS*/
/*<<<<<CONTENT*/
	echo SessionAlert::widget();
	echo $content;
?>
<?php
/*>>>>>CONTENT*/
/*<<<<<ENDBODY*/
?>
</main>
<hr/>
<footer aria-label='Pie de página' aria-hidden=true>
<?php
/*>>>>>ENDBODY*/
/*<<<<<FOOTER*/
?>
	<div class="d-flex justify-content-around">
		<p><?=$copyright_symbol?> <?= $company ?>, <?= date('Y') ?></p>
		<p><?= $created_by ?></p>
	</div>
</footer>
<?=	$this->endBody(); ?>
</body>
</html>
<?php
$this->endPage();
/*>>>>>FOOTER*/
