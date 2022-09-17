<?php
/*<<<<<MAIN*/
/**
 * @brief View of type index
 * @param yii\web\View $this
 * @param app\models\comp\CountrySearch $searchModel
 * @param array $indexParams
 */
use yii\helpers\{Html,Url};
use santilin\churros\grid\GridView;
use santilin\churros\helpers\{AppHelper,FormHelper};
/*>>>>>MAIN*/
/*<<<<<TITLE*/
$this->title = $searchModel->getModelInfo('title_plural'); // Countrys
$this->params['breadcrumbs'] = $this->context->genBreadCrumbs('index', $searchModel);
$gridPerms = AppHelper::mergePermissions('CDdISUR',$indexParams['permissions']??'');
/*>>>>>TITLE*/
/*<<<<<INDEX_BUTTONS*/
$indexButtons = [];
if( AppHelper::hasPermission($gridPerms, 'C') ) {
	$indexButtons['create'] = [
		'type' => 'a',
		'title' => Yii::t('app', 'Crear'),
		'url' => $this->context->actionRoute('create'),
		'htmlOptions' => ['class' => 'btn btn-success', 'data-pjax' => 0]
	];
}
if( AppHelper::hasPermission($gridPerms, 'S') ) {
	$indexButtons['search'] = [
		'type' => 'a',
		'title' => Yii::t('app', 'Filtros'), null,
		'url' => 'javascript:void(0);',
		'htmlOptions' => [
			'class' => 'btn btn-success search-button',
			'data-pjax' => 0,
			'onclick' => "$('.search-form').toggle(200);"
		]
	];
	if( !empty($_REQUEST[$searchModel->formName()]) ) {
		$indexButtons['reset'] = [
			'type' => 'a',
			'title' => Yii::t('app', 'Quitar filtros'),
			'url' => $this->context->actionRoute(['index', '_v'=>  ($_GET['_v']??'0')]),
			'htmlOptions' => ['class' => 'btn btn-danger', 'data-pjax' => 0]
		];
	}
}
$indexViews = [
'_grid' => '',
];
?>
<div class='country-index'>
<?php
if( count($indexViews) > 1 ) {
	$view_options = [];
	$nv = 0;
	foreach( $indexViews as $kv => $vtitle) {
		$view_options[$nv++] = $vtitle?:$kv;
	}
	$indexButtons['toggle_view']= [
		'type' => 'select',
		'title' => Yii::t('app', 'Vista'),
		'selections' => $_GET['_v']??0,
		'options' => $view_options,
		'htmlOptions' => [
			'class' => 'btn btn-secundary',
			'data-pjax' => 0,
			'onchange' => 'window.location.href="' . $this->context->actionRoute('index') . '?_v=" + this.selectedIndex'
		]
	];
}
/*>>>>>INDEX_BUTTONS*/
/*<<<<<INDEX_HEADER*/
echo $this->render(FormHelper::getViewFromRequest($indexViews, $indexParams), [
	'searchModel' => $searchModel,
	'indexParams' => $indexParams,
	'indexButtons' => $indexButtons,
	'gridPerms' => $gridPerms
]);
/*>>>>>INDEX_HEADER*/
/*<<<<<END*/
?>
</div><!-- country-index -->
<?php
/*>>>>>END*/
