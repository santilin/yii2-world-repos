<?php
/*<<<<<MAIN*/
/**
 * @param yii\web\View $this
 * @param app\models\Country $model
 * @param array $extraParams
 */
use yii\helpers\{Html,Url};
use santilin\churros\helpers\{AppHelper,FormHelper};

$viewViews = [
	'_view' => '',

];
if( !isset($extraParams) ) { $extraParams = []; }
/*>>>>>MAIN*/
/*<<<<<VIEW_TITLE*/
$this->title = $model->t('app', "{Title}: {record_short}");
$this->params['breadcrumbs'] = $this->context->genBreadCrumbs('view', $model);
$custom_title = FormHelper::getViewTitleFromRequest($viewViews, $extraParams);
if( $custom_title) {
	$this->params['breadcrumbs']['last'] = Yii::t('app', $custom_title);
}
$extraParams['permissions'] = AppHelper::mergePermissions('CDdISUR',$extraParams['permissions']??'');
/*>>>>>VIEW_TITLE*/
/*<<<<<DIV_CLASS*/
?>
<div class='country-view'>
<?php
/*>>>>>DIV_CLASS*/
/*<<<<<VIEW_PARTIAL*/
echo $this->render(FormHelper::getViewFromRequest($viewViews, $extraParams), [
	'model' => $model,
	'extraParams' => $extraParams,
]);
/*>>>>>VIEW_PARTIAL*/
/*<<<<<VIEW_END*/
?>
</div><!-- country-view -->
<?php
/*>>>>>VIEW_END*/
