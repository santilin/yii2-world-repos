<?php
/*<<<<<USES*/
/*Template:Yii2App/layouts/empty.php*/
/**
 * Yii2App Empty Bootstrap4 (default) layout
 * @var \yii\web\View $this
 * @var string $content
 */

use yii\helpers\Html;
use yii\bootstrap4\{Breadcrumbs,Nav,NavBar};
use santilin\wrepos\assets\SiteAsset;
use santilin\churros\helpers\AppHelper;
use santilin\churros\widgets\SessionAlert;

SiteAsset::register($this);
$company = $brand_name = Yii::$app->name;
$created_by = 'Creado por Santilín con Yii' . Yii::getVersion();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="description" content="World repositories" />
	<meta name="author" content="world-repos" />
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
<?php
echo $this->registerCsrfMetaTags();
if( !YII_ENV_DEV && AppHelper::yiiparam('baseUrl') ) {
	echo '<base href="' . AppHelper::yiiparam('baseUrl') . "\">\n";
}
?>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
<?php
/*>>>>>USES*/
/*<<<<<BODY*/
?>
</head>
<?php $this->beginBody() ?>
<body class="site light">
<div class="wrap">
	<div class="container">
		<?= SessionAlert::widget() ?>
		<?= $content ?>
	</div>
</div>
<footer class="footer">
<?php
/*>>>>>BODY*/
/*<<<<<FOOTER*/
?>
	<div class="container">
		<p class="float-sm-left">&copy; <?= $company ?>, <?= date('Y') ?></p>
		<p class="float-sm-right"><?= $created_by ?></p>
	</div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
/*>>>>>FOOTER*/
