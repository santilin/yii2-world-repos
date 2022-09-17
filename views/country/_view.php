<?php
/*<<<<<MAIN*/
use yii\helpers\{Html,Url};
use santilin\churros\helpers\{AppHelper,FormHelper};
use santilin\churros\yii\RecordView;

/**
 * @param yii\web\View $this
 * @param app\models\Country $model
 * @param array $extraParams
 */
/*>>>>>MAIN*/
/*<<<<<INIT*/
if( !isset($extraParams) ) {
	$extraParams = [];
}
$perms = $extraParams['permissions']??null;
$top_buttons = [];
/*>>>>>INIT*/
/*<<<<<BUTTONS*/
if( AppHelper::hasPermission($perms, 'U') ) {
	$top_buttons['update'] = [
		'type' => 'a',
		'title' => Yii::t('app', 'Editar'),
		'url' => $this->context->actionRoute(['update', 'id' => $model->getPrimaryKey()]),
		'htmlOptions' => [
			'class' => 'btn btn-success',
			'autofocus' => 'autofocus', 'tabindex'=>FormHelper::ti()
		]
    ];
}
if( AppHelper::hasPermission($perms, 'C') ) {
	$top_buttons['create'] = [
		'type' => 'a',
		'title' => Yii::t('app', 'Crear'),
		'url' => $this->context->actionRoute(['create']),
		'htmlOptions' => [
			'class' => 'btn btn-success',
			'autofocus' => 'autofocus', 'tabindex'=>FormHelper::ti()
		]
	];
}
if( AppHelper::hasPermission($perms, 'd') ) {
	$top_buttons['duplicate'] = [
		'type' => 'a',
		'title' => Yii::t('app', 'Duplicar'),
		'url' => $this->context->actionRoute(['duplicate', 'id' => $model->getPrimaryKey()]),
		'htmlOptions' => [
			'class' => 'btn btn-success',
			'autofocus' => 'autofocus', 'tabindex'=>FormHelper::ti()
		]
	];
}
if( AppHelper::hasPermission($perms, 'P') ) {
	$top_buttons['pdf'] = [
		'type' => 'a',
		'title' => '<span class="fa fa-book"></span> ' . Yii::t('app', 'PDF'),
		'url' => $this->context->actionRoute(['pdf', 'id' => $model->getPrimaryKey()]),
		'htmlOptions' => [
			'class' => 'btn btn-info',
			'autofocus' => 'autofocus', 'tabindex'=>FormHelper::ti(),
			'data-toggle' => 'tooltip',
			'target' => '_blank',
			'title' => Yii::t('app', 'Genera un PDF y lo abre en una ventana nueva'),
		]
	];
}
if( AppHelper::hasPermission($perms, 'D') ) {
	$top_buttons['delete'] = [
		'type' => 'a',
		'url' => $this->context->actionRoute(['delete', 'id' => $model->getPrimaryKey()]),
		'title' => Yii::t('app', 'Borrar'),
		'htmlOptions' => [
			'class' => 'btn btn-danger',
			'data' => [
				'confirm' => $model->t('app', "Realmente quieres borrar {la} {title} {record}?"),
				'method' => 'post',
			],
		]
	];
}
/*>>>>>BUTTONS*/
// tweak here your buttons and field options
/*<<<<<DISPLAY_FIELDS*/
$detailFields = [
'iso2' => [ // STRING
	'attribute' => 'iso2',
	'format' => 'raw' ],
'iso3' => [ // STRING
	'attribute' => 'iso3',
	'format' => 'raw' ],
'name' => [ // STRING
	'attribute' => 'name',
	'format' => 'raw' ],

];
/*>>>>>DISPLAY_FIELDS*/
// Tweak your buttons and fields here

/*<<<<<DISPLAY*/
$rv_opts = [
	'buttons' => $top_buttons,
	'layout' => '2cols',
	'title' => $this->title,
];
/*>>>>>DISPLAY*/
/*<<<<<DETAILWIDGET_FIELDS*/
echo RecordView::widget(array_merge([
	'model' => $model, 'attributes' => $detailFields ],
	$rv_opts));
/*>>>>>DETAILWIDGET_FIELDS*/

