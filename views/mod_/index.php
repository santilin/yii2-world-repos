<?php
/*<<<<<USES*/
/*Template:Yii2App/views/site_/index.php*/
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\bootstrap5\Html;
use app\helpers\UserHelper;

/**
 * @var \yii\web\View $this
 * @var array $params
 */
$this->title = 'World repositories';
$label_inicio = 'Inicio';
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
$welcome = "Bienvenid@ a world-repos";
/*<<<<<WELCOME*/
if ($welcome ?? false) : ?>
    <div class="jumbotron">
        <h1><?=$welcome?></h1>

    </div><!--jumbotron-->
<?php endif;
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
