<?php
/*<<<<<USES*/
/*Template:Yii2App/models/DbRecordModel.php*/

declare(strict_types=1);

namespace santilin\wrepos\models;

use santilin\wrepos\models\{Country, PostCode};
use santilin\wrepos\models\_BaseModel as Base_Place;
/*>>>>>USES*/
use Yii;
/*<<<<<CLASS*/
/**
 * This is the base model class for table `{{%places}}`.
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
 * @property \santilin\wrepos\models\Country $country // HasOne
 * @property \santilin\wrepos\models\PostCode[] $postCodes // BelongsToMany
 */
class Place extends Base_Place
{
	use \santilin\churros\RelationTrait;
	use \santilin\churros\models\ModelInfoTrait;
/*>>>>>CLASS*/
/*<<<<<STATIC_INFO*/
	public static function tableName()
	{
		return '{{%places}}';
	}
	/**
	 * @var array<string, array<string, string>>
	 */
	public static $relations = [
		'country' => [ 'model' => 'Country', 'left' => 'places.countries_id', 'right' => 'countries.id', 'modelClass' => 'santilin\wrepos\models\Country', 'relatedTablename' => 'countries', 'join' => 'places.countries_id = countries.id', 'type' => 'HasOne'],
		'postCodes' => [ 'model' => 'PostCode', 'left' => 'places.id', 'right' => 'postcodes.places_id', 'modelClass' => 'santilin\wrepos\models\PostCode', 'relatedTablename' => 'postcodes', 'join' => 'places.id = postcodes.places_id', 'type' => 'BelongsToMany'],
	];
/*>>>>>STATIC_INFO*/

/*<<<<<FIND_IF_NOT_QUERY*/
	/**
	 * @return \santilin\wrepos\models\comp\PlaceQuery the active query used by this AR class.
	 */
	public static function find()
	{
		if (class_exists("santilin\wrepos\models\comp\PlaceQuery")) {
			$q = new \santilin\wrepos\models\comp\PlaceQuery(get_called_class());
		} else {
			$q = parent::find();
		}
/*>>>>>FIND_IF_NOT_QUERY*/
/*<<<<<FIND_END*/
		return $q;
	} // find
/*>>>>>FIND_END*/

	static public function getDb()
	{
		if (Yii::$app->getModule('wrepos')) {
			return Yii::$app->getModule('wrepos')->db;
		} else {
			return Yii::$app->db;
		}
	}


/*<<<<<MODEL_INFO*/
	public static bool $isJunctionModel = false;
	protected static array $_model_info = [];
	public static function getModelInfo($part): string|bool
	{
		if (static::$_model_info === []) {
			$mi = [
				'model_name' => 'Place',
				'title' => 'Place',
				'title_plural' => 'Places',
				'code_field' => 'countries_id',
				'desc_field' => 'name',
				'controller_name' => 'place',
				'female' => true,
				'record_desc_format_short' => '{countries_id%ld}, {country}',
				'record_desc_format_medium' => '{countries_id%ld}, {country}, {name}',
				'record_desc_format_long' => '{countries_id%ld}, {country}, {name}',
			];
/*>>>>>MODEL_INFO*/
/*<<<<<MODEL_INFO_CUSTOM*/
			static::$_model_info = $mi;
		}
		return static::$_model_info[$part];
	}
/*>>>>>MODEL_INFO_CUSTOM*/
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
			'req' => [['name','countries_id'], 'required'],
			'int_id' => ['id', 'integer', 'min' => -2147483648, 'max' => 2147483647],

			'int_level' => ['level', 'integer', 'min' => -128, 'max' => 127],
			'null' => [['name_es','name_en','name_fr','admin_code','admin_sup_code','admin_sup_name','national_id'], 'default', 'value' => null],
			'def_level' => ['level', 'default', 'value' => 0],
		];
/*>>>>>RULES*/
/*<<<<<RULES.RETURN*/
		return $rules;
	} // rules
/*>>>>>RULES.RETURN*/
		// customize your rules here
/*<<<<<HANDY_VALUES*/
	public function handyFieldValues(
		string $field,
		string $format,
		string $model_format = 'medium',
		array|string|null $scope = null,
		string|null $filter_fields = null): array
	{
		$field_parts = explode('.', $field);
		if (count($field_parts) > 1) {
			$table = array_shift($field_parts);
			$rel_model_name = static::$relations[$table]['modelClass'];
			$rel_model = new $rel_model_name();
			return $rel_model->handyFieldValues(implode('.', $field_parts), $format, $model_format, $scope, $filter_fields);
		}
		$ret = $this->customFieldValues($field, $format, $model_format, $scope, $filter_fields);
		if ($ret === null) {
/*>>>>>HANDY_VALUES*/
/*<<<<<HANDY_VALUES.BODY*/
			if ($field === 'country') { // HasOne
				$q = Country::find();
				static::applyScopes($q, $scope);
				$models = $q->all();
				$ret = [];
				if ($filter_fields === null || trim($filter_fields) === '') {
					foreach ($models as $model) {
						$ret[$model->id] = $model->recordDesc($model_format);
					}
				} else {
					$fflds = explode(',', $filter_fields);
					foreach ($models as $model) {
						$ret[$model->id] = array_merge([$model->recordDesc($model_format)], $model->getAttributeValues($fflds));
					}
				}
			}
			if ($field === 'postCodes') { // hasMany
				$q = PostCode::find();
				static::applyScopes($q, $scope);
				$models = $q->all();
				$ret = [];
				if ($filter_fields === null || trim($filter_fields) === '') {
					foreach ($models as $model) {
						$ret[$model->places_id] = $model->recordDesc($model_format);
					}
				} else {
					$fflds = explode(',', $filter_fields);
					foreach ($models as $model) {
						$ret[$model->places_id] = array_merge([$model->recordDesc($model_format)], $model->getAttributeValues($fflds));
					}
				}
			}
/*>>>>>HANDY_VALUES.BODY*/
/*<<<<<HANDY_VALUES.RETURN*/
		}
		if ($format && $ret) {
			return $this->formatHandyFieldValues($field, $ret, $format);
		} elseif ($ret === null) {
			throw new \Exception($field . ": no handyFieldValues");
		} else {
			return $ret;
		}
	} // handyFieldValues
/*>>>>>HANDY_VALUES.RETURN*/
/*<<<<<DEFAULT_VALUES*/
	public function setDefaultValues()
	{
		if ($this->getScenario() === 'create') {
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
	public function getCountry() // HasOne
	{
		// Place.country:HasOne(not null) Country: places.countries_id=>countries.id
		return $this->hasOne(
			Country::class,
			['id' => 'countries_id'],
		);
	}
	public function getPostCodes() // HasMany
	{
		return $this->hasMany(
			PostCode::class,
			['places_id' => 'id'],
		);
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

	public function fullName(string $sep = ', ')
	{
		$parts = [$this->name];
		$place = $this;
		while ($place = $place->findSupPlaceById($place->id)) {
			$parts[] = $place->name;
		}
		return join($sep, $parts);
	}


	static public function importToModel(?callable $callback, string $dest_model_name, array $fields,
										 ?string $conds=null, string $country='ES'): int
	{
		$select_fields = [];
		$place_schema = Place::getTableSchema();
		$prim_keys = [];
		foreach ($fields as $dest => $orig) {
			if (is_numeric($dest)) {
				list($dest, $orig) = AppHelper::splitString($orig, ':');
			}
			if (empty($dest)) {
				$dest_schema = $dest_model_name::getTableSchema();
				throw new \Exception("$dest: wrong format. Must be dest_field:places_field\n"
					. 'Place fields: ' . implode(', ', array_keys($place_schema->columns)) . "\n"
					. "$dest_model_name fields: " . implode(', ', array_keys($dest_schema->columns)));
			}
			if ($orig == "nuts_code" || $orig == "code") {
				$orig = "admin_code";
			}
			if (!$place_schema->getColumn($orig)) {
				throw new \Exception("$orig: no field found in " . Place::tableName() . "\n");
			}
			if (empty($prim_keys)) {
				$prim_keys = [$orig, $dest];
			} else {
				$select_fields[$orig] = $dest;
			}
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
		$places = Place::find()->where($sql_conds)->orderBy('name')->all();
		foreach ($places as $place) {
			$dest_model = $dest_model_name::findOne($place->{$prim_keys[0]});
			if (!$dest_model) {
				$dest_model = new $dest_model_name;
				$dest_model->{$prim_keys[1]} = $place->{$prim_keys[0]};
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

	public function findPoblacion()
	{
		return intval($this->getDb()->createCommand("SELECT poblacion FROM entidades_es WHERE CODIGOINE = :codigoine",
			[ 'codigoine' => str_pad($this->national_id,11,'0',STR_PAD_RIGHT) ])->queryScalar());
	}

	public function findCodigoPostal(): ?string
	{
		$place = $this;
		$pc = null;
		while (!$pc) {
			$pc = PostCode::findOne(['places_id' => $place->id]);
			if (!$pc) {
				$place = $place->findSupPlaceById($place->id);
				if (!$place) {
					echo "Código postal de [{$this->id}]{$this->fullName()} no encontrado\n";
					return null;
				}
			}
		}
		if ($pc) {
			// echo "Encontrado código postal de [{$this->id}]{$this->fullName()}: {$pc->postcode}\n";
			return $pc->postcode;
		} else {
			return null;
		}
	}

/*<<<<<END*/
} // class Place
/*>>>>>END*/
