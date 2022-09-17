<?php
/*<<<<<MAIN*/
/**
 * @param yii\web\View $this
 * @param app\models\Country $model
 * @param array $extraParams
 * @param array $buttons_up
 * @param array $buttons // down
 */

use yii\helpers\{Html,Url};
use yii\bootstrap4\ActiveForm;
use santilin\churros\helpers\{AppHelper,FormHelper};
/*>>>>>MAIN*/
/*<<<<<FORM_DIV*/
if( $_SESSION['browser']??'' == 'mobile' ) {
	$form_options = [
		'id' => 'country-crud-form',
		'successCssClass' => '',
		'layout' => 'inline',
		'fieldConfig' => [
			'labelOptions' => ['class' => ''],
			'enableError' => true,
		]
	];
} else {
	$form_options = [
		'id' => 'country-crud-form',
		'successCssClass' => '',
		'layout' => 'horizontal',
	];
}
$fields_layout = '2cols';
?>
<div class='country-crud-form'>
<?php
/*>>>>>FORM_DIV*/
/*<<<<<FORM*/
$form = ActiveForm::begin($form_options);
echo $form->errorSummary($model);
?>
	<div class='form-fields'>
<?php
$hidden_fields = ['id' => Html::activeHiddenInput($model, 'id')];
/*>>>>>FORM*/
/*<<<<<FORM_FIELDS_PRE*/
$fields_layout_rows = [];
$fldcfg = [];
$hidden_fields['_form_referrer'] =  Html::hiddenInput('_form_referrer', Yii::$app->request->referrer );
$input_opts['iso2']=[
	'placeholder' => '', 'maxlength' => 2,
	'tabindex' => FormHelper::ti(), 'autofocus'=>'autofocus',
];
$input_opts['iso3']=[
	'placeholder' => '', 'maxlength' => 2,
	'tabindex' => FormHelper::ti(), 'autofocus'=>'autofocus',
];
$input_opts['name']=[
	'placeholder' => '', 'maxlength' => null,
	'tabindex' => FormHelper::ti(), 'autofocus'=>'autofocus',
];
/*>>>>>FORM_FIELDS_PRE*/
// Tweak your form fields options
/*<<<<<FORM_FIELDS_LAYOUT*/
if ( $fields_layout != "inline" ) {
	FormHelper::fixLayoutFields($fields_layout, $fields_layout_rows, $input_opts, $fldcfg);
}
/*>>>>>FORM_FIELDS_LAYOUT*/
/*<<<<<FORM_FIELDS*/
$form_fields['iso2'] = // STRING
	$form->field($model, 'iso2', $fldcfg['iso2']??[])
	->textInput($input_opts['iso2']);
$form_fields['iso3'] = // STRING
	$form->field($model, 'iso3', $fldcfg['iso3']??[])
	->textInput($input_opts['iso3']);
$form_fields['name'] = // STRING
	$form->field($model, 'name', $fldcfg['name']??[])
	->textInput($input_opts['name']);
/*>>>>>FORM_FIELDS*/
// Tweak your form fields and form options here

/*<<<<<DISPLAY_BUTTONS_UP*/
if( !empty($buttons_up) ) {
?>
<div class="row"><div class="col-sm-12">
	<?= FormHelper::layoutButtons($buttons_up, $fields_layout, 'bs4') ?>
<?php
}
/*>>>>>DISPLAY_BUTTONS_UP*/
/*<<<<<DISPLAY_FIELDS*/
foreach($hidden_fields as $key => $hf ) {
	echo (string)$hf;
}
echo FormHelper::layoutFields($fields_layout, $form_fields, $fields_layout_rows);
?>
	</div><!-- form-fields -->
<?php
/*>>>>>DISPLAY_FIELDS*/
/*<<<<<DISPLAY_BUTTONS*/
if( !empty($buttons) ) {
	echo FormHelper::layoutButtons($buttons, $fields_layout, 'bs4');

}
/*>>>>>DISPLAY_BUTTONS*/
/*<<<<<FORM_END*/
	ActiveForm::end();
?>
</div><!-- country-crud-form -->
<?php
if( FormHelper::getConfig('FormEnterAsTab', '_form', false) ) {
	$this->registerJs(<<<js
document.getElementById('{$form->id}').addEventListener('keydown', formEnterAsTab);
js
	);
}
/*>>>>>FORM_END*/

