<?php
/*<<<<<MAIN*/
use yii\helpers\Html;
use santilin\churros\helpers\FormHelper;
use santilin\churros\ModelSearchTrait;
use yii\bootstrap4\ActiveForm;

/* @var yii\web\View $this */
/* @var CountrySearch $searchModel */
/* @var string $viewname */


$form_options = [
	'action' => ['index'],
	'method' => 'get',
	'id' => "search-index-form",
	'layout' => 'horizontal',
];
/*>>>>>MAIN*/
// tweak the form fields options here
/*<<<<<FORM*/
?>
<div class='country-search-form'>
    <?php $form = ActiveForm::begin( $form_options ); ?>
	<div class='country-search-form-fields'>
<?php
$form_fields = [];
$form_fields['iso2'] = // STRING
    $searchModel->createSearchField('iso2', 'string' );
$form_fields['iso3'] = // STRING
    $searchModel->createSearchField('iso3', 'string' );
$form_fields['name'] = // STRING
    $searchModel->createSearchField('name', 'string' );
/*>>>>>FORM*/
// Tweak here your form fields

/*<<<<<DISPLAY_FIELDS*/
foreach( $form_fields as $name => $code ) {
	echo $form_fields[$name]. "\n";
}
/*>>>>>DISPLAY_FIELDS*/
/*<<<<<FORM_BUTTONS*/
?>
	</div>
	<div class='country form-group'>
		<div class="col-sm-3">
		</div>
		<div class="col-sm-6">
			<?= Html::submitButton(Yii::t('app', 'Filtrar'), ['class' => 'btn btn-primary']) ?>
			<?= Html::a(Yii::t('app', 'Cerrar'), null,
				['class' => 'btn btn-success search-button',
				'onclick' => "$('.search-form').toggle(200);",
				'data-pjax' => 0]) ?>
			<?= Html::a(Yii::t('app', '+/- filtros'), null,
				['class' => 'btn btn-secondary',
				'data-toggle' => "collapse",
				'data-target' => ".hideme",
				'data-pjax' => 0]) ?>
		</div>
	</div>
<?php
/*>>>>>FORM_BUTTONS*/
/*<<<<<FORM_END*/
	ActiveForm::end();
?>
</div>
<?php
/*>>>>>FORM_END*/

