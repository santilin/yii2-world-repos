<?php
/*<<<<<MAIN*/
/**
 * @param yii\web\View $this
 * @param app\models\Country $model
 * @param array $extraParams
 */

use yii\helpers\{Html,Url};
use santilin\churros\helpers\FormHelper;

$duplicateForms = [
	'_form' => '',

];
if( !isset($extraParams) ) { $extraParams = []; }
$custom_title = FormHelper::getViewTitleFromRequest($duplicateForms, $extraParams);
/*>>>>>MAIN*/
/*<<<<<TITLE*/
$this->params['breadcrumbs'] = $this->context->genBreadCrumbs('duplicate', $model);
if( $custom_title ) {
	$this->title = $custom_title;
	$last_crumb = array_pop($this->params['breadcrumbs']);
	$this->params['breadcrumbs'][] = $model->t('app', $custom_title);
} else {
	$this->title = $model->t('app', 'Duplicando {title}: : {record_short}');
}
$buttons = $buttons_up = [];
/*>>>>>TITLE*/
/*<<<<<BUTTONS*/
$buttons['duplicate'] = [
    'type' => 'submit',
    'title' => Yii::t('app', 'Duplicar'),
    'htmlOptions' => [
        'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
		'autofocus' => 'autofocus', 'tabindex'=>FormHelper::ti()
    ]
];
$buttons['cancel'] = [
    'type' => 'a',
    'title' => Yii::t('app', 'Cancelar'),
	'url' => Yii::$app->request->get('cancelUrl', Yii::$app->request->referrer),
	'htmlOptions' => [
		'class'=> 'btn btn-danger', 'autofocus' => 'autofocus',
		'tabindex'=>FormHelper::ti()
    ]
];
?>
<div class='country-duplicate'>
<?php
// tweak the buttons below
/*>>>>>BUTTONS*/
/*<<<<<DUPLICATE_CONTENT*/
echo $this->render(FormHelper::getViewFromRequest($duplicateForms, $extraParams), [
	'model' => $model, 'extraParams' => $extraParams,
	'buttons' => $buttons, 'buttons_up' => $buttons_up ]);
/*>>>>>DUPLICATE_CONTENT*/
/*<<<<<END*/
?>
</div><!-- country-duplicate -->
<?php
/*>>>>>END*/
