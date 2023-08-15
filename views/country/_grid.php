<?php
/*<<<<<GRID_COLUMNS_PRE*/
/**
 * @param yii\web\View $this
 * @param app\models\comp\CountrySearch $searchModel
 * @param array $indexParams
 * @param array $indexButtons
 * @param string $gridPerms
 * @param string $act_but_template
 */
use yii\helpers\Html;
use santilin\churros\helpers\FormHelper;
use santilin\churros\grid\GridView;

$columns_controller = $this->context->actionRoute(null, $searchModel); // valid for crud and detailcrud controllers
/*>>>>>GRID_COLUMNS_PRE*/
/*<<<<<GRID_COLUMNS*/
$gridColumns = [
	[
		'class' => \santilin\churros\grid\ActionColumn::class,
		'controller' => $columns_controller,
		'crudPerms' => $gridPerms,
		'buttonOptions' => [ 'class' => 'action-button' ],
		'deleteOptions' => [ 'style' => 'color:red;'],
		'contentOptions' => ['style' => 'white-space:nowrap']
	],
'id' => [ // hidden
	'attribute' => 'id',
	'visible' => YII_DEBUG
],
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
/*>>>>>GRID_COLUMNS*/
// Tweak the grid column options here
// Tweak the grid columns here
/*<<<<<DEFAULT_SORT*/
$gridOrder = [];
/*>>>>>DEFAULT_SORT*/
/*<<<<<GRID_DATA*/
if( !empty($act_but_template) ) {
	$gridColumns[0]['template'] = $act_but_template;
}
$searchModel->addSafeRules($gridColumns);
$dataProvider = $searchModel->search($indexParams);
if( count($gridOrder) > 0 ) {
	$dataProvider->sort->defaultOrder = $gridOrder;
}
$searchModel->addRelatedSortsToProvider($gridColumns, $dataProvider);
$beforeGrid = [ 'div_open' => "<div class='toolbar btn-toolbar'>", ]
+ [ FormHelper::displayButtons($indexButtons) ]
+ [
	'next_div' => "</div><div class='search-form' style='display:none'>",
	'search_form' => $this->render( '_search', ['searchModel' => $searchModel]),
	'div_close' => "</div>"
];
$searchModel->transformGridFilterValues();
$gridGroups = [];
/*>>>>>GRID_DATA*/
/*<<<<<GRID_OPTIONS*/
$gridOptions = [
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
	'columns' => $gridColumns,
	'groups' => $gridGroups,
	'bsVersion' => '4.x',

	'itemLabelSingle' => 'country',
	'itemLabelPlural' => 'countrys',

	'pjax' => true,
	'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-field']],
 	'panel' => [
 		'type' => GridView::TYPE_PRIMARY,
 		'heading' => '<span class="glyphicon glyphicon-list-alt"></span>  ' . Html::encode($this->title),
 		'before' => join("", $beforeGrid) ],
	'condensed' => true,
	'hover' => true,
	'export' => false,
];
// tweak your grid options below
/*>>>>>GRID_OPTIONS*/
/*<<<<<GRID_WIDGET*/
	echo GridView::widget( $gridOptions );
/*>>>>>GRID_WIDGET*/

