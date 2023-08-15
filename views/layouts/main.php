<?php
/*<<<<<USES*/
/*Template:Yii2App/layouts/main.php*/
/**
 * Yii2App Main Bootstrap4 (default) layout
 * @var \yii\web\View $this
 * @var string $content
 */

use yii\helpers\Html;
use yii\bootstrap4\{Breadcrumbs,Nav,NavBar};
use app\assets\MainAsset;
use santilin\churros\helpers\AppHelper;
use santilin\churros\widgets\SessionAlert;

MainAsset::register($this);
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
$company = "Santilín";
/*<<<<<BODY*/
?>
</head>
<?php $this->beginBody() ?>
<body class="site">

<div class="wrap">
<div class="header">
<?php
$home_link = null;
if( '' != '' ) {
	$home_link = [ 'label' => Yii::t('app', 'Repositories'), 'url' => ['/']];
}
$navbar_options = [
	'brandLabel' => '<span>' . (isset(Yii::$app->params['logo'])
		? Html::img(Yii::$app->params['logo'], ['id' => 'app-logo']) : '' ) . '&nbsp;'
		. $brand_name,
	'brandUrl' => Yii::$app->homeUrl,
	'options' => [
		'class' => 'nav navbar navbar-expand-md navbar-light',
	],
];
/*>>>>>BODY*/
/*<<<<<MENU_USER*/
$items_main = []; // Main menu
$login_menu = [];
$login_items = [];
$user_component = '' != '' ? Yii::$app->get('user') : null;
if( $user_component ) {
	$username = $user_component->getIdentity() ? $user_component->getIdentity()->username : '';
} else {
	$user_name = 'Invitada';
}
/*>>>>>MENU_USER*/
/*<<<<<LOGINMENU*/
if( count($login_items) == 1 ) {
	$login_menu = reset($login_items);
} else if( count($login_items) > 1 ) {
	$login_menu = [ 'label' => $username ?: Yii::t('app', 'Acceso'), 'url' => '#', 'items' => $login_items, 'visible' => true ];
}
/*>>>>>LOGINMENU*/
/*<<<<<MENUITEMS_PRE*/

/*>>>>>MENUITEMS_PRE*/
/*<<<<<MENUITEMS*/

/*>>>>>MENUITEMS*/
/*<<<<<NAVMENUS*/
$nav_menu_options = [
	'options' => ['class' => 'navbar-nav ml-auto mt-2 mt-lg-0' ],
	'items' => array_merge(	$items_main),
];
NavBar::begin($navbar_options);
/*>>>>>NAVMENUS*/
/*<<<<<MENU_BEGIN*/
echo Nav::widget($nav_menu_options);
NavBar::end();
/*>>>>>MENU_BEGIN*/
/*<<<<<MENU_END*/
	?>
</div><!--header-->
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
		<p class="float-sm-left">&copy; <?= $company ?>, <?= date('Y') ?></p>
		<p class="float-sm-right"><?= $created_by ?></p>
	</div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
/*>>>>>FOOTER*/
/*<<<<<PROFILES_LINKS*/
if( $user_component ) {
	foreach( \app\components\Capel::modulesWithAccess($user_component) as $km => $name ) {
		$login_items[$km] = ['label' => Yii::t('app', $name), 'url' => Url::to('/$km') ];
	}
}
/*>>>>>PROFILES_LINKS*/
