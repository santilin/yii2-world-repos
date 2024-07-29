<?php
/*<<<<<USES*/
/*Template:Yii2App/models/DbRecordModel.php*/
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
 * @property integer $level // tinyInteger
 * @property string $name_es // places/name
 * @property string $name_en // places/name
 * @property string $name_fr // places/name
 * @property string $admin_code
 * @property string $admin_sup_code
 * @property string $admin_sup_name
 * @property string $national_id
 * @property integer $countries_id
 *
 * @property santilin\wrepos\models\Country $country // HasOne
 * @property santilin\wrepos\models\PostCode[] $postCodes // BelongsToMany
 */
class Place extends \santilin\wrepos\models\_BaseModel
{
	use \santilin\churros\RelationTrait;
	use \santilin\churros\ModelInfoTrait;
/*>>>>>CLASS*/
/*<<<<<STATIC_INFO*/
	static public function tableName()
	{
		return '{{%places}}';
	}
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
				'model_name' => 'Place',
				'title' => 'Place',
				'title_plural' => 'Places',
				'code_field' => 'id',
				'desc_field' => 'name',
				'controller_name' => 'place',
				'female' => true,
				'record_desc_format_short' => '{country}',
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
			'level' => 'Level',
			'name_es' => 'Name es',
			'name_en' => 'Name en',
			'name_fr' => 'Name fr',
			'admin_code' => 'Admin code',
			'admin_sup_code' => 'Admin sup code',
			'admin_sup_name' => 'Admin sup name',
			'national_id' => 'National id',
			'countries_id' => Country::getModelInfo('title'), // HasOne
			'country' => Country::getModelInfo('title'), // HasOne
			'postCodes' => PostCode::getModelInfo('title_plural'), // belongstomany
		];
/*>>>>>LABELS*/
		// customize your labels here
/*<<<<<LABELS.RETURN*/
 		return $labels;
	} // attributeLabels
/*>>>>>LABELS.RETURN*/
/*<<<<<RULES*/
    public function rules()
    {
		$rules = [
			'req' => [['name','countries_id'], 'required', 'on' => $this->getCrudScenarios()],
			'int_level' => ['level', 'integer', 'min' => -128, 'max' => 127, 'on' => $this->getCrudScenarios()],
			'null' => [['name_es','name_en','name_fr','admin_code','admin_sup_code','admin_sup_name','national_id'], 'default', 'value' => null],
			'def_level'=>['level', 'default', 'value' => 0,'on' => $this->getCrudScenarios()],
		];
/*>>>>>RULES*/
		// customize your rules here
/*<<<<<RULES_RETURN*/
		return $rules;
    } // rules
/*>>>>>RULES_RETURN*/
/*<<<<<HANDY_VALUES_PRE*/
	public function handyFieldValues(string $field, string $format,
		string $model_format = 'medium', array|string $scope=null, ?string $filter_fields = null)
	{
		$field_parts = explode('.', $field);
		if (count($field_parts) > 1) {
			$table = array_shift($field_parts);
			$rel_model_name = static::$relations[$table]['modelClass'];
			$rel_model = new $rel_model_name;
			return $rel_model->handyFieldValues(implode('.', $field_parts), $format, $model_format, $scope);
		}
		$ret = null;
		if (is_array($scope)) {
			$scope_func = array_shift($scope); $scope_args = $scope;
		} else {
			$scope_func = $scope; $scope_args = [];
		}
/*>>>>>HANDY_VALUES_PRE*/
/*<<<<<HANDY_VALUES.BODY*/
		if( $field == 'countries_id' || $field == 'country' || $field == 'Country' ) { // HasOne
			$q = Country::find();
			$q->defaultOrder();
			if( $scope_func ) {
				call_user_func_array([$q,$scope_func],$scope_args);
			}
			$models = $q->all();
			$ret = [];
			if (empty($filter_fields)) {
				foreach($models as $model) {
					$ret[$model->getPrimaryKey()] = $model->recordDesc($model_format);
				}
			} else {
				$fflds = explode(',',$filter_fields);
				foreach($models as $model) {
					$ret[$model->getPrimaryKey()] = array_merge([$model->recordDesc($model_format)], array_values($model->getAttributes($fflds)));
				}
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
			if (empty($filter_fields)) {
				foreach($models as $model) {
					$ret[$model->getPrimaryKey()] = $model->recordDesc($model_format);
				}
			} else {
				$fflds = explode(',',$filter_fields);
				foreach($models as $model) {
					$ret[$model->getPrimaryKey()] = array_merge([$model->recordDesc($model_format)], array_values($model->getAttributes($fflds)));
				}
			}
		}
/*>>>>>HANDY_VALUES.BODY*/
/*<<<<<HANDY_VALUES.RETURN*/
		if ($ret === null) {
			return parent::handyFieldValues($field, $format, $model_format, $scope, $filter_fields);
		} else {
			if ($format) {
				return $this->formatHandyFieldValues($field, $ret, $format);
			} else {
				return $ret;
			}
		}
	} // handyFieldValues
/*>>>>>HANDY_VALUES.RETURN*/
/*<<<<<DEFAULT_VALUES*/
	public function setDefaultValues(bool $duplicating = false)
	{
		if (!$duplicating) { // Dont set these default values while duplicating
			$this->level = 0;
		}
/*>>>>>DEFAULT_VALUES*/
/*<<<<<DEFAULT_VALUES.RETURN*/
	} // setDefaultValues
/*>>>>>DEFAULT_VALUES.RETURN*/
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
		// Tweak or add report fields here
/*<<<<<RELATIONS*/
	/**
	 * The keys of the array refer to the attributes of the record associated
	 * with the `$class` model, while the values of the
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
