<?php
/*<<<<<USES*/
/*Template:Yii2App/layouts/site.php*/
/**
 * Yii2App Bootstrap5 'site' layout
 * @var \yii\web\View $this
 * @var string $content
 */

use yii\helpers\{Html,Url};
use yii\bootstrap5\{Breadcrumbs,Nav,NavBar};
use santilin\wrepos\assets\0Asset;
use santilin\churros\widgets\SessionAlert;
use app\helpers\UserHelper;

0Asset::register($this);
$company = $brand_name = Yii::$app->name;
$copyright_symbol = '&copy;';
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
<body class="0" data-bs-theme="light">
<div class="container">
<header aria-label='World repositories'>
<?php
$home_link = null;
if( '0' != 'site' ) {
	$home_link = [ 'label' => Yii::t('app', 'Repositories'), 'url' => ['/0']];
}
$navbar_options = [
	'brandLabel' => '<span>' . (isset(Yii::$app->params['logo'])
		? Html::img(Yii::$app->params['logo'], ['id' => 'app-logo']) : '' ) . '&nbsp;'
		. $brand_name,
	'brandUrl' => Yii::$app->homeUrl,
	'options' => [
		'class' => 'navbar navbar-expand-md',
		'aria-label' => 'Menú principal',
	],
];
/*>>>>>BODY*/
/*<<<<<MENU_USER*/
$items_main = []; // Main menu
$login_menu = [];
$login_items = [];
$user_component = Yii::$app->get('user', false);
$username = $user_component?->getIdentity()?->username ?: '';
$user_is_admin = UserHelper::userIsAdmin();
/*>>>>>MENU_USER*/
/*<<<<<LOGINMENU*/
if( count($login_items) == 1 ) {
	$login_menu[] = reset($login_items);
} else if( count($login_items) > 1 ) {
	$login_menu[] = [ 'label' => $username ?: Yii::t('app', 'Acceso'), 'url' => '#', 'items' => $login_items, 'visible' => true ];
}
/*>>>>>LOGINMENU*/
/*<<<<<MENUITEMS_PRE*/

/*>>>>>MENUITEMS_PRE*/
/*<<<<<MENUITEMS*/

/*>>>>>MENUITEMS*/
/*<<<<<NAVMENUS*/
$nav_menu_options = [
	'options' => ['class' => 'navbar-nav ms-auto' ],
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
</header>
<main aria-label='Contenido'>
	<?= Breadcrumbs::widget([
		'homeLink' => $home_link,
		'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
		'options' => [ 'aria' => [ 'hidden' => 'true' ]],
	]) ?>
	<?= SessionAlert::widget() ?>
	<?= $content ?>
</main>
<footer aria-label='Pié de página' class="footer mt-auto py-3">
<?php
/*>>>>>MENU_END*/
/*<<<<<FOOTER*/
?>
	<hr/>
	<div class="row">
		<div class="col-sm-6">
			<p class="text-start"><?=$copyright_symbol?> <?= $company ?>, <?= date('Y') ?></p>
		</div>
		<div class="col-sm-6">
			<p class="text-end"><?= $created_by ?></p>
		</div>
	</div>
</footer>
<?php $this->endBody() ?>
</div><!-- container-->
</body>
</html>
<?php $this->endPage();
/*>>>>>FOOTER*/
/*<<<<<PROFILES_LINKS*/
if( $user_component ) {
	foreach( \app\components\Capel::modulesWithAccess($user_component) as $km => $name ) {
		$login_items[$km] = ['label' => Yii::t('app', $name), 'url' => Url::to("/$km") ];
	}
}
/*>>>>>PROFILES_LINKS*/
