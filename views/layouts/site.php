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
use santilin\wrepos\assets\SiteAsset;
use santilin\churros\widgets\SessionAlert;
use app\helpers\UserHelper;

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
$company = "Santilín";
/*<<<<<BODY*/
?>
</head>
<?php $this->beginBody() ?>
<body class="site">
<header class=container aria-label="Navegación">
<?php
/*>>>>>BODY*/
/*<<<<<NAVIGATION*/
$home_link = null; // 
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
/*>>>>>NAVIGATION*/
/*<<<<<MENU_USER*/
$items_main = []; // Main menu
$login_menu = [];
$login_items = [];
$user_component = Yii::$app->get('user', false);
$username = $user_component?->getIdentity()?->username ?: 'Invitada';
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
/*>>>>>MENU_BEGIN*/
/*<<<<<MENU_END*/
NavBar::end();
	?>
</header>
<main class=container aria-label="Contenido">
<?php
/*>>>>>MENU_END*/
/*<<<<<BREADCRUMBS*/
	echo Breadcrumbs::widget([
		'homeLink' => $home_link,
		'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
		'options' => [ 'aria' => [ 'hidden' => 'true' ]],
	]);
	echo SessionAlert::widget();
	echo $content;
?>
</main>
<footer aria-label='Pie de página' aria-hidden=true>
<?php
/*>>>>>BREADCRUMBS*/
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
/*<<<<<PROFILES_LINKS*/
if( $user_component ) {
	foreach( \app\components\Capel::modulesWithAccess($user_component) as $km => $name ) {
		$login_items[$km] = ['label' => Yii::t('app', $name), 'url' => Url::to("/$km") ];
	}
}
/*>>>>>PROFILES_LINKS*/
