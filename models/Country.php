<?php
/*<<<<<USES*/
/*Template:Yii2App/models/Model.php*/
namespace santilin\wrepos\models;

use Yii;
use santilin\churros\helpers\{AppHelper,DateTimeEx,FormHelper};
/*>>>>>USES*/
/*<<<<<CLASS*/
/**
 * This is the base model class for table "{{%countries}}".
 *
 * @property integer $id // key/primary/tiny
 * @property string $iso2 // places/country/iso2_code
 * @property string $iso3 // places/country/iso3_code
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
/*>>>>>CLASS*/
/*<<<<<STATIC_INFO*/
	static public $relations = [

	];
/*>>>>>STATIC_INFO*/
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
     * @return \santilin\wreposforms\CountryQuery the active query used by this AR class.
     */
    static public function find()
    {
		if( class_exists("santilin\wrepos\models\comp\CountryQuery") ) {
			return new \santilin\wrepos\models\comp\CountryQuery(get_called_class());
		} else {
			return parent::find();
		}
    } // find
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
			'req' => [['iso2','iso3'], 'required', 'on' => $this->crudScenarios],
			'null' => [['name'], 'default', 'value' => null],
			'max_iso2'=>['iso2', 'string', 'max' => 2, 'on' => $this->crudScenarios],
			'max_iso3'=>['iso3', 'string', 'max' => 3, 'on' => $this->crudScenarios],
		];
/*>>>>>RULES*/
		// customize your rules here

/*<<<<<RULES_RETURN*/
		return $rules;
    } // rules
/*>>>>>RULES_RETURN*/
/*<<<<<HANDY_VALUES_PRE*/
	public function handyFieldValues(string $field, string $format, ?string $model_format = 'short', string $scope=null)
	{
		$field_parts = explode('.', $field);
		if( count($field_parts) > 1 ) {
			$table = array_shift($field_parts);
			$rel_model_name = static::$relations[$table]['modelClass'];
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
			return $this->defaultHandyFieldValues($field, $format, $model_format, $scope);
		} else {
			if( $format ) {
				return $this->formatHandyFieldValues($field, $ret, $format);
			} else {
				return $ret;
			}
		}
	} // handyFieldValues
/*>>>>>HANDY_VALUES_RETURN*/
/*<<<<<BEHAVIORS*/
	public function behaviors()
	{
		$behaviors = parent::behaviors();
/*>>>>>BEHAVIORS*/
		// customize or add your behaviors here
/*<<<<<BEHAVIORS.RETURN*/
		return $behaviors;
    } // behaviors
/*>>>>>BEHAVIORS.RETURN*/
/*<<<<<REPORT_COLUMNS*/
	static public function allReportColumns($relname = null)
	{
		if( $relname === null ) {
			$relname = 'countries';
		}
		$ret = [
			"$relname.desc_short" => [
				'attribute' => "CONCAT($relname.iso2, ', ', $relname.name)",
				'label' => static::getModelInfo('title'),
			],
			"$relname.id" => [ // tinyInteger
				'format' => 'integer',
			],
			"$relname.iso2" => [ // string
				'format' => 'raw',
			],
			"$relname.iso3" => [ // string
				'format' => 'raw',
			],
			"$relname.name" => [ // string
				'format' => 'raw',
			],
		];
/*>>>>>REPORT_COLUMNS*/
		// Tweak or add report fields here
/*<<<<<REPORT_COLUMNS.END*/
		return $ret;
	}
/*>>>>>REPORT_COLUMNS.END*/
/*<<<<<END*/
} // class Country
/*>>>>>END*/

