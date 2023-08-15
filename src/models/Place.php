<?php
/*<<<<<USES*/
/*Template:Yii2App/models/Model.php*/
namespace santilin\wrepos\models;

use Yii;
use santilin\churros\helpers\{AppHelper,DateTimeEx,FormHelper};
/*>>>>>USES*/
/*<<<<<CLASS*/
/**
 * This is the base model class for table "{{%places}}".
 *
 * @property integer $id // key/primary/tiny
 * @property string $contry_code // places/country/iso2_code
 * @property string $name // places/name
 * @property float $postcode // places/postcode
 * @property string $nuts_code
 * @property string $nuts3_id
 * @property string $city_name
 * @property string $greater_city
 * @property string $city_id
 * @property string $lau_id
 * @property string $fua_id
 *
 */
class Place extends \yii\db\ActiveRecord
{
	use \santilin\churros\ModelInfoTrait;
	static public function tableName()
	{
		return '{{%places}}';
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
				'title' => 'Place',
				'title_plural' => 'Places',
				'code_field' => 'contry_code',
				'desc_field' => 'name',
				'controller_name' => 'place',
				'female' => true,
				'record_desc_format_short' => '{contry_code}, {name}',
				'record_desc_format_medium' => '{contry_code}, {name}',
				'record_desc_format_long' => '{contry_code}, {name}, {postcode%.0f}'
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
     * @return \santilin\wreposforms\PlaceQuery the active query used by this AR class.
     */
    static public function find()
    {
		if( class_exists("santilin\wrepos\models\comp\PlaceQuery") ) {
			return new \santilin\wrepos\models\comp\PlaceQuery(get_called_class());
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
			'contry_code' => 'Contry code',
			'name' => 'Name',
			'postcode' => 'Postcode',
			'nuts_code' => 'Nuts code',
			'nuts3_id' => 'Nuts3 id',
			'city_name' => 'City name',
			'greater_city' => 'Greater city',
			'city_id' => 'City id',
			'lau_id' => 'Lau id',
			'fua_id' => 'Fua id',
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
			'req' => [['contry_code','name'], 'required', 'on' => $this->crudScenarios],
			'def0'=>[['postcode'], 'default', 'value' => 0.0,'on' => $this->crudScenarios],
			'number_postcode'=>['postcode', 'number'],
			'null' => [['nuts_code','nuts3_id','city_name','greater_city','city_id','lau_id','fua_id'], 'default', 'value' => null],
			'max_contry_code'=>['contry_code', 'string', 'max' => 2, 'on' => $this->crudScenarios],
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
/*<<<<<DEFAULT_VALUES*/
	public function setDefaultValues(bool $duplicating = false)
	{
		if (!$duplicating) {
			$this->postcode = 0.0;
		} else {

		}
/*>>>>>DEFAULT_VALUES*/
/*<<<<<DEFAULT_VALUES_RETURN*/
	} // setDefaultValues
/*>>>>>DEFAULT_VALUES_RETURN*/
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
			$relname = 'places';
		}
		$ret = [
			"$relname.desc_long" => [
				'attribute' => "CONCAT($relname.contry_code, ', ', $relname.name, ', ', $relname.postcode)",
				'label' => static::getModelInfo('title'),
			],

			"$relname.desc_short" => [
				'attribute' => "CONCAT($relname.contry_code, ', ', $relname.name)",
				'label' => static::getModelInfo('title'),
			],
			"$relname.id" => [ // tinyInteger
				'format' => 'integer',
			],
			"$relname.contry_code" => [ // string
				'format' => 'raw',
			],
			"$relname.name" => [ // string
				'format' => 'raw',
			],
			"$relname.postcode" => [ // decimal
				'format' => 'decimal',
			],
			"$relname.nuts_code" => [ // string
				'format' => 'raw',
			],
			"$relname.nuts3_id" => [ // string
				'format' => 'raw',
			],
			"$relname.city_name" => [ // string
				'format' => 'raw',
			],
			"$relname.greater_city" => [ // string
				'format' => 'raw',
			],
			"$relname.city_id" => [ // string
				'format' => 'raw',
			],
			"$relname.lau_id" => [ // string
				'format' => 'raw',
			],
			"$relname.fua_id" => [ // string
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
} // class Place
/*>>>>>END*/
