<?php
/*<<<<<MAIN*/
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

/* var yii\web\View $this */
/* @var $params array */
$this->title = 'World repositories';
$label_inicio = Yii::t('app', 'Inicio');
/*>>>>>MAIN*/
/*<<<<<BREADCRUMBS*/
$this->params['breadcrumbs'] = [ $label_inicio ];
// 	'homeLink' => [
// 		'label' => $label_inicio,
// 		'url' => ['/']
// 	],
// ];
?>
<div class="site-index">
<?php
/*>>>>>BREADCRUMBS*/
/*<<<<<WELCOME*/
if( !empty($welcome) ) : ?>
    <div class="jumbotron">
        <h1><?=$welcome?></h1>

    </div><!--jumbotron-->
<?php endif ?>
    <div class="body-content">
		<ul class="index-menu">
<?php
/*>>>>>WELCOME*/
/*<<<<<NO_USERS_MODELS_MENU*/
?>

<?php
/*>>>>>NO_USERS_MODELS_MENU*/
/*<<<<<END*/
?>
		</ul>
    </div>
    </div><!--body-content-->
</div><!--site-index-->
<?php
/*>>>>>END*/
