<?php
/*<<<<<MAIN*/
/**
 * @param yii\web\View $this
 * @param app\models\Country $model
 * @param array $extraParams
 */
use yii\helpers\{Url,Html};
use santilin\churros\helpers\FormHelper;

$updateForms = [
	'_form' => '',

];
if( !isset($extraParams) ) { $extraParams = []; }
$custom_title = FormHelper::getViewTitleFromRequest($updateForms, $extraParams);
/*>>>>>MAIN*/
/*<<<<<TITLE*/
$this->params['breadcrumbs'] = $this->context->genBreadCrumbs('update', $model);
if( $custom_title ) {
	$this->title = $custom_title;
	$last_crumb = array_pop($this->params['breadcrumbs']);
	$this->params['breadcrumbs'][] = $model->t('app', $custom_title);
} else {
	$this->title = $model->t('app', 'Editando {title}: : {record_short}');
}
$buttons = $buttons_up = [];
/*>>>>>TITLE*/
/*<<<<<BUTTONS*/
$buttons['update'] = [
    'type' => 'submit',
    'title' => Yii::t('app', 'Guardar'),
    'htmlOptions' => [
        'class' => 'btn btn-primary',
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
// tweak the buttons below
?>
<div class='country-update'>
<?php
/*>>>>>BUTTONS*/
/*<<<<<FORM*/
echo $this->render(FormHelper::getViewFromRequest($updateForms, $extraParams), [
	'model' => $model, 'extraParams' => $extraParams,
	'buttons' => $buttons, 'buttons_up' => $buttons_up ]);
/*>>>>>FORM*/
/*<<<<<END*/
?>
</div><!-- country-update -->
<?php
/*>>>>>END*/
