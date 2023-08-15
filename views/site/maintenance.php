<?php
/*<<<<<USES*/
/*Template:Yii2App/views/site/maintenance.php*/
use yii\helpers\{Html,Url};

/* var yii\web\View $this */
/* @var $params array */

$welcome = Yii::t('app','Modo mantenimiento');
$this->title = 'World repositories - ' . $welcome;
/*>>>>>USES*/
/*<<<<<MAINTENANCE*/
?>
<div class="site-maintenance">
<?php
/*>>>>>MAINTENANCE*/
/*<<<<<WELCOME*/
if( !empty($welcome) ) : ?>
    <div class="jumbotron">
        <h1><?=$welcome?></h1>

    </div><!--jumbotron-->
<?php endif ?>
    <div class="body-content">
    <div class='alert alert-warning text-center'><?=$message?></div>
<?php
/*>>>>>WELCOME*/
/*<<<<<END*/
?>
    </div><!--body-content-->
</div><!--site-maintenance-->
<?php
/*>>>>>END*/
