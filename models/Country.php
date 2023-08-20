<?php
/*<<<<<USES*/
/*Template:Yii2App/models/DbRecordModel.php*/
namespace santilin\wrepos\models;

use Yii;
use santilin\churros\helpers\{AppHelper,DateTimeEx,FormHelper};
use santilin\wrepos\models\Place;
/*>>>>>USES*/
/*<<<<<CLASS*/
/**
 * This is the base model class for table "{{%countries}}".
 *
 * @property integer $id // key/primary/tiny
 * @property string $iso2 // places/country/iso2_code
 * @property string $iso3 // places/country/iso3_code
 * @property string $name // places/country/name
 * @property string $name_es // places/country/name
 * @property string $name_en // places/country/name
 * @property string $name_fr // places/country/name
 *
 * @property santilin\wrepos\models\Place[] $places // BelongsToMany
 */
class Country extends \santilin\wrepos\models\_BaseModel
{
	use \santilin\churros\ModelInfoTrait;
	static public function tableName()
	{
		return '{{%countries}}';
	}
/*>>>>>CLASS*/
/*<<<<<STATIC_INFO*/
	static public $relations = [
'places' => [ 'model' => 'Place', 'left' => 'countries.id', 'right' => 'places.countries_id', 'modelClass' => 'santilin\wrepos\models\Place', 'relatedTablename' => 'places', 'join' => 'countries.id = places.countries_id', 'type' => 'BelongsToMany']
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
				'record_desc_format_long' => '{iso2}, {name}, {name_es}, {name_en}, {name_fr}'
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
			'name_es' => 'Name es',
			'name_en' => 'Name en',
			'name_fr' => 'Name fr',
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
			'null' => [['name','name_es','name_en','name_fr'], 'default', 'value' => null],
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
	public function handyFieldValues(string $field, string $format, ?string $model_format = 'short', ?string $scope=null)
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
		if( $field == 'places' ) { // hasMany
			$q = Place::find();
			$q->defaultOrder();
			if( $scope_func ) {
				call_user_func_array([$q,$scope_func],$scope_args);
			}
			$models = $q->all();
			$ret = [];
			foreach($models as $model) {
				$ret[$model->getPrimaryKey()] = $model->recordDesc($model_format);
			}
		}
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
			"$relname.desc_long" => [
				'attribute' => "CONCAT($relname.iso2, ', ', $relname.name, ', ', $relname.name_es, ', ', $relname.name_en, ', ', $relname.name_fr)",
				'label' => static::getModelInfo('title'),
			],

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
			"$relname.name_es" => [ // string
				'format' => 'raw',
			],
			"$relname.name_en" => [ // string
				'format' => 'raw',
			],
			"$relname.name_fr" => [ // string
				'format' => 'raw',
			],
		];
/*>>>>>REPORT_COLUMNS*/
		// Tweak or add report fields here
/*<<<<<REPORT_COLUMNS.END*/
		return $ret;
	}
/*>>>>>REPORT_COLUMNS.END*/
/*<<<<<RELATIONS*/
	/**
	 * The keys of the array refer to the attributes of the record associated
	 *	with the `$class` model, while the values of the
     * array refer to the corresponding attributes in **this** AR class.
     */
	public function getPlaces()
	{
		// places:Country BelongsToMany(inv)(not null) Place: countries.id=>places.countries_id
		return $this->hasMany(\santilin\wrepos\models\Place::class, ['countries_id' => 'id'])->inverseOf('country');
	}
/*>>>>>RELATIONS*/
/*<<<<<END*/
} // class Country
/*>>>>>END*/

