<?php
/*<<<<<MAIN*/
/**
 * @param yii\web\View $this
 * @param app\models\Country $model
 * @param array $extraParams
 */
use yii\helpers\{Html,Url};
use santilin\churros\helpers\FormHelper;

$createForms = [
	'_form' => '',

];
if( !isset($extraParams) ) { $extraParams = []; }
$custom_title = FormHelper::getViewTitleFromRequest($createForms, $extraParams);
/*>>>>>MAIN*/
/*<<<<<CREATE_TITLE*/
$this->params['breadcrumbs'] = $this->context->genBreadCrumbs('create', $model);
if( $custom_title ) {
	$this->title = $custom_title;
	$last_crumb = array_pop($this->params['breadcrumbs']);
	$this->params['breadcrumbs'][] = $model->t('app', $custom_title);
} else {
	$this->title = $model->t('app', 'Creando {title}');
}
$buttons = $buttons_up = [];
/*>>>>>CREATE_TITLE*/
/*<<<<<BUTTONS*/
if( FormHelper::getConfig('CreateAnother', 'Country', false) ) {
	$buttons['create_and_continue'] = [
        'tpype' => 'submit',
		'title' => Yii::t('app', 'Crear'),
		'htmlOptions' => [
			'class' => 'btn btn-success',
			'value' => '1', 'name' => '_and_create',
			'autofocus' => 'autofocus', 'tabindex'=>FormHelper::ti()
        ]
    ];
} else {
	$buttons['create'] = [
        'type' => 'submit',
        'title' => Yii::t('app', 'Crear') ,
        'htmlOptions' => [
            'class' => 'btn btn-success',
            'autofocus' => 'autofocus', 'tabindex'=>FormHelper::ti()
        ]
    ];
}
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
<div class='country-create'>
<?php
/*>>>>>BUTTONS*/
/*<<<<<CREATE_CONTENT*/
echo $this->render(FormHelper::getViewFromRequest($createForms, $extraParams), [
	'model' => $model, 'buttons' => $buttons, 'buttons_up' => $buttons_up,
	'extraParams' => $extraParams ]);
/*>>>>>CREATE_CONTENT*/
/*<<<<<END*/
?>
</div><!--country-create -->
<?php
/*>>>>>END*/
