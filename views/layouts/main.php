<?php
/*<<<<<HEAD*/
/**
 * Yii2App Main Bootstrap4 (default) layout
 * @var \yii\web\View $this
 * @var string $content
 */

use yii\helpers\Html;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use app\assets\Asset;
use santilin\churros\helpers\AppHelper;
use santilin\churros\yii\bootstrap4\SessionAlert;

Asset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta name="description" content="World repositories">
	<meta name="author" content="world-repos">
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
/*>>>>>HEAD*/
$company = "Santilín";
/*<<<<<BODY*/
?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    $extra_navbar_classes = 'ml-auto mt-2 mt-lg-0';
	$home_link = null;
	if( '' != '' ) {
		$home_link = [ 'label' => Yii::t('app', 'Repositories'), 'url' => ['/']];
	}
    NavBar::begin([
        'brandLabel' => '<span>' . (isset(Yii::$app->params['logo'])
			? Html::img(Yii::$app->params['logo'], ['id' => 'app-logo']) : '' ) . '&nbsp;'
			. Yii::$app->name,
        'brandUrl' => isset($home_link['url'])? $home_link['url'] : Yii::$app->homeUrl,
        'options' => [
            'class' => 'nav navbar navbar-expand-md navbar-light bg-dark',
        ],
    ]);
$items_main = []; // Main menu
$login_menu = [];
$login_items = [];
$user_module = Yii::$app->user;
/*>>>>>BODY*/
/*<<<<<LOGINMENU*/
if( count($login_items) != 0 ) {
	$login_menu = [ 'label' => $user_module->identity ? $user_module->identity->username : 'Acceso', 'items' => $login_items ];
}
/*>>>>>LOGINMENU*/
/*<<<<<MENUITEMS_PRE*/

/*>>>>>MENUITEMS_PRE*/
/*<<<<<MENUITEMS*/

/*>>>>>MENUITEMS*/
/*<<<<<NAVMENUS*/
$menu_options = [
	'options' => ['class' => "navbar-nav $extra_navbar_classes"],
	'items' => array_merge(		[[
		'label' => Yii::t('app', 'Menú'), 'items' => $items_main, 'url' => '#'
	]]
),
];
/*>>>>>NAVMENUS*/
/*<<<<<MENU_BEGIN*/
	echo Nav::widget($menu_options);
	NavBar::end();
/*>>>>>MENU_BEGIN*/
/*<<<<<MENU_END*/
	?>

	<div class="container">
		<?= Breadcrumbs::widget([
			'homeLink' => $home_link,
			'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
		]) ?>
		<?= SessionAlert::widget() ?>
		<?= $content ?>
	</div>
</div>
<footer class="footer">
<?php
/*>>>>>MENU_END*/
/*<<<<<FOOTER*/
?>
	<div class="container">
		<p class="float-sm-left">&copy; <?= $company ?> <?= date('Y') ?></p>
		<p class="float-sm-right">Desarrollado por Santilín con Yii2</p>
	</div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
/*>>>>>FOOTER*/
