<?php
/*<<<<<USES*/
/*Template:Yii2App/views/site/index.php*/
use yii\helpers\{Html,Url};
use yii\widgets\Breadcrumbs;

/* var yii\web\View $this */
/* @var $params array */
if( 'Repositories' == '' ) {
	$this->title = 'World repositories';
} else {
	$this->title = 'World repositories - Repositories';
}
$label_inicio = Yii::t('app', 'Inicio');
/*>>>>>USES*/
/*<<<<<BREADCRUMBS*/
$this->params['breadcrumbs'] = [ $label_inicio ];
// 	'homeLink' => [
// 		'label' => $label_inicio,
// 		'url' => ['/']
// 	],
// ];
/*>>>>>BREADCRUMBS*/
/*<<<<<MAIN_DIV*/
?>
<div class="site-index">
<?php
/*>>>>>MAIN_DIV*/
/*<<<<<WELCOME*/
if( !empty($welcome) ) : ?>
    <div class="jumbotron">
        <h1><?=$welcome?></h1>

    </div><!--jumbotron-->
<?php endif
/*>>>>>WELCOME*/
/*<<<<<BODY_CONTENT*/
?>
    <div class="body-content">
<?php
/*>>>>>BODY_CONTENT*/
/*<<<<<NO_USERS_MODELS_MENU*/
?>

<?php
/*>>>>>NO_USERS_MODELS_MENU*/
/*<<<<<END*/
?>
    </div><!--body-content-->
</div><!--site-index-->
<?php
/*>>>>>END*/
