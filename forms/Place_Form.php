<?php
/*<<<<<USES*/
/*Template:Yii2App/models/ModelForm.php*/
namespace santilin\wreposforms;

use Yii;
use santilin\wrepos\models\Place;
use santilin\churros\helpers\FormHelper;
/*>>>>>USES*/
/*<<<<<CLASS*/
/**
 * This is a custom form class for model Place
 *
 */
class Place_Form extends Place
{
/*>>>>>CLASS*/
/*<<<<<RULES*/
    public function rules()
    {
		$rules = array_merge(parent::rules(), [
			'f_safe'=>[['id'], 'safe', 'on' => $this->getCrudScenarios()],
			'req' => [['name','level','countries_id'], 'required', 'on' => $this->getCrudScenarios()],
			'null' => [['name_es','name_en','name_fr','admin_code','admin_sup_code','admin_sup_name','national_id'], 'default', 'value' => null, 'on' => $this->getCrudScenarios()],
		]);
/*>>>>>RULES*/
/*<<<<<RULES_RETURN*/
		return $rules;
    } // rules
/*>>>>>RULES_RETURN*/
/*<<<<<AFTER_SAVE*/
	public function afterSave($insert, $changedAttributes)
	{
		parent::afterSave($insert, $changedAttributes);
		$fdf = FormHelper::getConfig('Place_Form', 'DefaultValues', []);
		if( is_array($fdf) ) {
			$df = [];
			foreach($fdf as $fld => $value) {
				$df[$fld] = $this->$fld;
			}
			if( !empty($df) ) {
				FormHelper::setConfig('Place_Form', 'DefaultValues', $df);
			}
		} else {
			FormHelper::setConfig('Place_Form', 'DefaultValues', []);
		}
/*>>>>>AFTER_SAVE*/
/*<<<<<AFTER_SAVE.END*/
	}
/*>>>>>AFTER_SAVE.END*/
/*<<<<<DEFAULT_VALUES*/
	// @param controller $context
	public function setDefaultValues($context = null, bool $duplicating = false)
	{
		parent::setDefaultValues($context, $duplicating);
/*>>>>>DEFAULT_VALUES*/
/*<<<<<DEFAULT_VALUES.PARENT*/

		if (!$duplicating) { // dont set these default values while duplicating

		}
		$fdf = FormHelper::getConfig('Place_Form', 'DefaultValues', []);
		if( !empty($fdf) ) {
			$this->setAttributes($fdf);
		}
/*>>>>>DEFAULT_VALUES.PARENT*/
/*<<<<<DEFAULT_VALUES.RETURN*/
	} // setDefaultValues
/*>>>>>DEFAULT_VALUES.RETURN*/
/*<<<<<END*/
} // class Place_Form
/*>>>>>END*/
		// customize your great rules here
