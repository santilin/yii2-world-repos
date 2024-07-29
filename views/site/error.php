<?php
/*<<<<<USES*/
/* var yii\web\View $this */
/* @var $name string */
/* @var $message string */
/* @var Exception $exception */

use yii\helpers\Html;

$this->title = $name??'Error';
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
<?php
    if (Yii::$app->user?->identity?->getIsAdmin()) {
?>
        <p><?= Yii::t('app', 'Como administrador/a,')?></p>
<?php
    } else if (!Yii::$app->user?->isGuest) {
?>
        <p><?= Yii::t('app', 'Como usuario/a,')?></p>
<?php
    } else {
?>
        <p><?= Yii::t('app', 'Como invitado/a,')?></p>
<?php
    }
?>

        <?= nl2br(Html::encode(mb_lcfirst($message))) ?>
    </div>

<?php
if ((YII_ENV_TEST||YII_ENV_DEV) && isset($exception) && $exception->getPrevious()) {
?>
    <p>
        <?= Yii::$app->request->absoluteUrl ?>
    </p>
	<h2>Extended developer info</h2>
	<p><?= $exception->getPrevious()->getMessage() ?></p>
<?php
}
/*>>>>>USES*/
