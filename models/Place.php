<?php
/*<<<<<USES*/
/*Template:Yii2App/models/Model.php*/
namespace santilin\wrepos\models;

use Yii;
use santilin\churros\helpers\{AppHelper,DateTimeEx,FormHelper};
use santilin\wrepos\models\Country;
use santilin\wrepos\models\PostCode;
/*>>>>>USES*/
/*<<<<<CLASS*/
/**
 * This is the base model class for table "{{%places}}".
 *
 * @property integer $id // key/primary/tiny
 * @property string $name // places/name
 * @property string $nuts_code
 * @property string $nuts3_id
 * @property string $city_name
 * @property string $greater_city
 * @property string $city_id
 * @property string $lau_id
 * @property string $fua_id
 * @property integer $countries_id
 *
 * @property santilin\wrepos\models\Country $country // HasOne
 * @property santilin\wrepos\models\PostCode[] $postCodes // BelongsToMany
 */
class Place extends _BaseModel
{
	use \santilin\churros\ModelInfoTrait;
	static public function tableName()
	{
		return '{{%places}}';
	}
/*>>>>>CLASS*/
/*<<<<<STATIC_INFO*/
	static public $relations = [
'country' => [ 'model' => 'Country', 'left' => 'places.countries_id', 'right' => 'countries.id', 'modelClass' => 'santilin\wrepos\models\Country', 'relatedTablename' => 'countries', 'join' => 'places.countries_id = countries.id', 'type' => 'HasOne'],
'postCodes' => [ 'model' => 'PostCode', 'left' => 'places.id', 'right' => 'postcodes.places_id', 'modelClass' => 'santilin\wrepos\models\PostCode', 'relatedTablename' => 'postcodes', 'join' => 'places.id = postcodes.places_id', 'type' => 'BelongsToMany']
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
				'code_field' => 'id',
				'desc_field' => 'name',
				'controller_name' => 'place',
				'female' => true,
				'record_desc_format_short' => '{country}, {name}',
				'record_desc_format_medium' => '{country}, {name}',
				'record_desc_format_long' => '{country}, {name}'
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
			'name' => 'Name',
			'nuts_code' => 'Nuts code',
			'nuts3_id' => 'Nuts3 id',
			'city_name' => 'City name',
			'greater_city' => 'Greater city',
			'city_id' => 'City id',
			'lau_id' => 'Lau id',
			'fua_id' => 'Fua id',
			'countries_id' => Country::getModelInfo('title'), // HasOne
			'country' => Country::getModelInfo('title'), // HasOne
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
			'req' => [['name','countries_id'], 'required', 'on' => $this->crudScenarios],
			'null' => [['nuts_code','nuts3_id','city_name','greater_city','city_id','lau_id','fua_id'], 'default', 'value' => null],
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
		if( $field == 'countries_id' || $field == 'country' || $field == 'Country' ) { // HasOne
			$q = Country::find();
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
		if( $field == 'postCodes' ) { // hasMany
			$q = PostCode::find();
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
			$relname = 'places';
		}
		$ret = [

			"$relname.id" => [ // tinyInteger
				'format' => 'integer',
			],
			"$relname.name" => [ // string
				'format' => 'raw',
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
			"$relname.countries_id" => [ // HasOne
				'format' => 'integer',
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
	public function getCountry()
	{
		// country:Place HasOne(not null) Country: places.countries_id=>countries.id
		return $this->hasOne(\santilin\wrepos\models\Country::class, ['id' => 'countries_id']);
	}
	/**
	 * The keys of the array refer to the attributes of the record associated
	 *	with the `$class` model, while the values of the
     * array refer to the corresponding attributes in **this** AR class.
     */
	public function getPostCodes()
	{
		// postCodes:Place BelongsToMany(inv)(not null) PostCode: places.id=>postcodes.places_id
		return $this->hasMany(\santilin\wrepos\models\PostCode::class, ['places_id' => 'id'])->inverseOf('place');
	}
/*>>>>>RELATIONS*/
/*<<<<<END*/
} // class Place
/*>>>>>END*/
