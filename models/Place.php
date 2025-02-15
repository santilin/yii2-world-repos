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
 * @property integer $id // key/primary
 * @property string $name // places/name
 * @property integer $level // tinyInteger
 * @property string $name_es // places/name
 * @property string $name_en // places/name
 * @property string $name_fr // places/name
 * @property string $admin_code
 * @property string $admin_sup_code
 * @property string $admin_sup_name
 * @property string $national_id
 * @property integer $countries_id // smallInteger
 *
 * @property santilin\wrepos\models\Country $country // HasOne
 * @property santilin\wrepos\models\PostCode[] $postCodes // BelongsToMany
 */
class Place extends \santilin\wrepos\models\_BaseModel
{
	use \santilin\churros\RelationTrait;
	use \santilin\churros\models\ModelInfoTrait {
		handyFieldValues as trait_handyFieldValues;
	}
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
	static public $isJunctionModel = false;
	static protected $_model_info = [];
	static public function getModelInfo($part)
	{
		if (static::$_model_info == [] ) {
			$mi = [
				'model_name' => 'Place',
				'title' => 'Place',
				'title_plural' => 'Places',
				'code_field' => 'countries_id',
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

			'int_countries_id' => ['countries_id', 'integer', 'min' => -32768, 'max' => 32767, 'on' => $this->getCrudScenarios()],
			'null' => [['name_es','name_en','name_fr','admin_code','admin_sup_code','admin_sup_name','national_id'], 'default', 'value' => null],
			'def_level'=>['level', 'default', 'value' => 0, 'on' => $this->getCrudScenarios()],
		];
/*>>>>>RULES*/
		// customize your rules here
/*<<<<<RULES_RETURN*/
		return $rules;
    } // rules
/*>>>>>RULES_RETURN*/
/*<<<<<HANDY_VALUES_PRE*/
	public function handyFieldValues(string $field, string $format,
		string $model_format = 'medium', array|string|null $scope = null, ?string $filter_fields = null)
	{
		$field_parts = explode('.', $field);
		if (count($field_parts) > 1) {
			$table = array_shift($field_parts);
			$rel_model_name = static::$relations[$table]['modelClass'];
			$rel_model = new $rel_model_name;
			return $rel_model->handyFieldValues(implode('.', $field_parts), $format, $model_format, $scope, $filter_fields);
		}
		$ret = null;
/*>>>>>HANDY_VALUES_PRE*/
/*<<<<<HANDY_VALUES.BODY*/
		if( $field == 'countries_id' || $field == 'country' || $field == 'Country' ) { // HasOne
			$q = Country::find();
			static::applyScopes($q, $scope);
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
			static::applyScopes($q, $scope);
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
			return $this->trait_handyFieldValues($field, $format, $model_format, $scope, $filter_fields);
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
	// @param controller $context
	public function setDefaultValues()
	{
		if ($model->getScenario() != 'duplicating') { // Dont set these default values while duplicating
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
	 * The keys of the array refer to the attributes of the record associated with the `$class` model,
	 * while the values of the array refer to the corresponding attributes in **this** AR class.
	 */
	public function getCountry()
	{
		// Place.country:HasOne(not null) Country: places.countries_id=>countries.id
		return $this->hasOne(\santilin\wrepos\models\Country::class,
			['id'=>"countries_id"]);
	}
	/**
	 * The keys of the array refer to the attributes of the record associated
	 *	with the `$class` model, while the values of the
     * array refer to the corresponding attributes in **this** AR class.
     */
	public function getPostCodes()
	{
		// Place.postCodes:BelongsToMany(inv)(not null) PostCode: places.id=>postcodes.places_id
		return $this->hasMany(\santilin\wrepos\models\PostCode::class,
			['places_id'=>"id"])
			->inverseOf('place');
	}
/*>>>>>RELATIONS*/

	static public function findSupPlaceById(int $places_id): ?Place
	{
		$place = self::findOne($places_id);
		if ($place && $place->admin_sup_code) {
			return self::findOne(['admin_code' => $place->admin_sup_code]);
		} else {
			return null;
		}
	}

	static public function importToModel(?callable $callback, string $dest_model_name, array $fields, string $conds=null, string $country='ES'): int
	{
		$select_fields = [];
		$place_schema = Place::getTableSchema();
		foreach ($fields as $field) {
			list($dest, $orig) = AppHelper::splitString($field, ':');
			if (empty($dest)) {
				throw new \Exception("$field: wrong format. Must be orig_field:dest_field\n");
			}
			if ($orig == "nuts_code" || $orig == "code") {
				$orig = "admin_code";
			}
			if (!$place_schema->getColumn($orig)) {
				throw new \Exception("$orig: no field found in " . Place::tableName() . "\n");
			}
			$select_fields[$orig] = $dest;
		}
		$country_id = Country::find()->where(['or', [ 'iso2' => $country], ['iso3' => $country], ['name' => $country]])->scalar();
		if (!$country_id) {
			$this->stderr( "$country: country not found\n");
			exit(1);
		}
		$sql_conds = "countries_id=$country_id";
		if (!empty($conds) && $conds != 'null') {
			$sql_conds .= " AND $conds";
		}
		$places = Place::find()->where($sql_conds)->all();
		foreach ($places as $place) {
			$dest_model = $dest_model_name::findOne($place->id);
			if (!$dest_model) {
				$dest_model = new $dest_model_name;
				$dest_model->id = $place->id;
			}
			foreach ($select_fields as $orig_field => $dest_field) {
				switch ($orig_field) {
					case 'admin_code':
						if ($place->level < 6) {
							$dest_model->$dest_field = implode('-', array_filter([$place->admin_sup_code,$place->admin_code]));
						} else {
							$dest_model->$dest_field = $place->admin_code;
						}
						break;
					default:
						$dest_model->$dest_field = $place->$orig_field;
				}
			}
			if (is_callable($callback)) {
				call_user_func($callback, $dest_model, $place);
			}
			if (!$dest_model->save()) {
				throw new \Exception('Place not saved: ' . $dest_model->recordDesc('long')
					. ": errors: " . implode(", ", $dest_model->getErrorSummary(true)));
			}
		}
		return count($places);
	}



/*<<<<<END*/
} // class Place
/*>>>>>END*/
