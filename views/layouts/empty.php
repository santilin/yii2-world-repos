<?php
/*<<<<<USES*/
/*Template:Yii2App/layouts/empty.php*/
/**
 * Yii2App Empty Bootstrap5 'empty' layout
 * @var \yii\web\View $this
 * @var string $content
 */
use yii\helpers\Html;
use santilin\wrepos\assets\SiteAsset;
use santilin\churros\widgets\SessionAlert;

SiteAsset::register($this);
$company = $brand_name = Yii::$app->name;
$copyright_symbol = '&copy;';
$created_by = 'Creado por Santilín con Yii' . Yii::getVersion();
/*>>>>>USES*/
/*<<<<<BEGINPAGE*/
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" data-bs-theme=auto>
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
<header class=container aria-label="Navegación">
<?php
/*>>>>>BODY*/
/*<<<<<CONTENT*/
	echo SessionAlert::widget();
	echo $content;
?>
</main>
<footer aria-label='Pie de página' aria-hidden=true>
<?php
/*>>>>>CONTENT*/
/*<<<<<FOOTER*/
?>
	<hr/>
	<div class="d-flex justify-content-around">
		<p><?=$copyright_symbol?> <?= $company ?>, <?= date('Y') ?></p>
		<p><?= $created_by ?></p>
	</div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
/*>>>>>FOOTER*/
