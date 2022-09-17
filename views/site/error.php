<?php
/*<<<<<MAIN*/
/* var yii\web\View $this */
/* @var $title string */
/* @var $message string */
/* @var Exception $exception */

use yii\helpers\Html;

$this->title = $title??'Error';
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

<?php
if (YII_ENV_DEV && isset($exception) && $exception->getPrevious()) {
?>
    <p>
        <?= Yii::$app->request->absoluteUrl ?>
    </p>
	<h2>Extended developer info</h2>
	<p><?= $exception->getPrevious()->getMessage() ?></p>
<?php
}
/*>>>>>MAIN*/
