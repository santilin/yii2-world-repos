<?php
/*<<<<<USES*/
/*Template:Yii2App/models/FormModel.php*/
namespace santilin\wrepos\forms;

use santilin\wrepos\models\Place;
use santilin\churros\helpers\FormHelper;
use Yii;
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
		$parent_rules = parent::rules();
		$rules = [
			'f_safe' => [['id'], 'safe'],
			'req' => [['name','level','countries_id'], 'required'],
			'null' => [['name_es','name_en','name_fr','admin_code','admin_sup_code','admin_sup_name','national_id'], 'default', 'value' => null],
		];
/*>>>>>RULES*/
/*<<<<<RULES.RETURN*/
		$rules = array_merge($parent_rules, $rules);
		return $rules;
    } // rules
/*>>>>>RULES.RETURN*/
/*<<<<<AFTER_SAVE*/
	public function afterSave($insert, $changedAttributes)
	{
		parent::afterSave($insert, $changedAttributes);
		$fdf = FormHelper::getConfig('Place_Form', 'DefaultValues', []);
		if (is_array($fdf)) {
			$df = [];
			foreach (array_intersect_assoc($this->activeAttributes(), $fdf) as $fld => $value) {
				$df[$fld] = $this->__get($fld);
			}
			if (count($df) !== 0) {
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
	public function setDefaultValues()
	{
		parent::setDefaultValues();
/*>>>>>DEFAULT_VALUES*/
/*<<<<<DEFAULT_VALUES.PARENT*/
		$fdf = FormHelper::getConfig('Place_Form', 'DefaultValues', []);
		if (count($fdf) !== 0) {
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
