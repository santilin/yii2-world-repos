<?php
/*<<<<<USES*/
namespace app\models;

use Yii;
use santilin\churros\helpers\{AppHelper,DateTimeEx,FormHelper};
/*>>>>>USES*/
/*<<<<<CLASS*/
/**
 * This is the base model class for table "{{%countries}}".
 *
 * @property integer $id // key/primary/tiny
 * @property string $iso2
 * @property string $iso3
 * @property string $name // places/country/name
 *
 */
class Country extends \yii\db\ActiveRecord
{

	use \santilin\churros\ModelInfoTrait;
	static public function tableName()
	{
		return '{{%countries}}';
	}

	static public $relations = [

	];
/*>>>>>CLASS*/
/*<<<<<MODEL_INFO*/
	static public $_model_info = [];
	static public function getModelInfo($part)
	{
		if (static::$_model_info == [] ) {
			$mi = [
				'title' => 'Country',
				'title_plural' => 'Countrys',
				'code_field' => 'iso2',
				'desc_field' => 'name',
				'controller_name' => 'country',
				'female' => true,
				'record_desc_format_short' => '{iso2}, {name}',
				'record_desc_format_medium' => '{iso2}, {name}',
				'record_desc_format_long' => '{iso2}, {name}'
			];
/*>>>>>MODEL_INFO*/
/*<<<<<MODEL_INFO_CUSTOM*/
			static::$_model_info = $mi;
		}
		return static::$_model_info[$part];
	}
/*>>>>>MODEL_INFO_CUSTOM*/
/*<<<<<FIND*/
	/**
     * @return \app\models\comp\CountryQuery the active query used by this AR class.
     */
    static public function find()
    {
		if( class_exists("app\models\comp\CountryQuery") ) {
			return new \app\models\comp\CountryQuery(get_called_class());
		} else {
			return parent::find();
		}
    } // find
    static public function getSearchClass()
    {
		return "app\models\comp\CountrySearch";
	}
/*>>>>>FIND*/
/*<<<<<LABELS*/
	public function attributeLabels()
	{
		$labels = [
			'id' => 'Id',
			'iso2' => 'Iso2',
			'iso3' => 'Iso3',
			'name' => 'Name',
		];
/*>>>>>LABELS*/
		// customize your labels here
/*<<<<<LABELS_RETURN*/
 		return $labels;
	} // attributeLabels
/*>>>>>LABELS_RETURN*/
/*<<<<<RULES*/
    public function rules()
    {
		$rules = [
			'safe'=>[['iso2','iso3','name'], 'safe'],
			'req'=>[['iso2','iso3'], 'required'],
			'max0'=>[['iso2'], 'string', 'max' => 2 ],
			'max1'=>[['iso3'], 'string', 'max' => 2 ],
		];
/*>>>>>RULES*/
		// customize your rules here

/*<<<<<RULES_RETURN*/
		return $rules;
    } // rules
/*>>>>>RULES_RETURN*/
/*<<<<<HANDY_VALUES_PRE*/
	public function handyFieldValues($field, $format, $scope=null)
	{
		$field_parts = explode('.', $field);
		if( count($field_parts) > 1 ) {
			$table = array_shift($field_parts);
			$rel_model_name = "\\app\\models\\$table";
			$rel_model = new $rel_model_name;
			return $rel_model->handyFieldValues(implode('.', $field_parts), $format, $scope);
		}
		$ret = null;
		$scope_args = [];
		if( is_array($scope) ) {
			$scope_func = array_shift($scope);
			$scope_args = $scope;
		} else {
			$scope_func = $scope;
		}
/*>>>>>HANDY_VALUES_PRE*/
/*<<<<<HANDY_VALUES*/

/*>>>>>HANDY_VALUES*/
/*<<<<<HANDY_VALUES_RETURN*/
		if( $ret === null ) {
			return $this->defaultHandyFieldValues($field, $format, $scope);
		} else {
			if( $format ) {
				return $this->formatHandyFieldValues($ret, $format);
			} else {
				return $ret;
			}
		}
	} // handyFieldValues
/*>>>>>HANDY_VALUES_RETURN*/
/*<<<<<END*/
} // class Country
/*>>>>>END*/

