<?php
/*<<<<<USES*/
/*Template:Yii2App/models/DbRecordModel.php*/

declare(strict_types=1);

namespace santilin\wrepos\models;

use santilin\wrepos\models\{Place};
use santilin\wrepos\models\_BaseModel as Base_Country;
/*>>>>>USES*/
/*<<<<<CLASS*/
/**
 * This is the base model class for table `{{%countries}}`.
 *
 * @property integer $id // key/primary/small
 * @property string $iso2 // places/country/iso2_code
 * @property string $iso3 // places/country/iso3_code
 * @property string $name // places/country/name
 * @property string $name_es // places/country/name
 * @property string $name_en // places/country/name
 * @property string $name_fr // places/country/name
 * @property santilin\wrepos\models\Place[] $places // BelongsToMany
 */
class Country extends Base_Country
{
	use \santilin\churros\NoRelationTrait;
	use \santilin\churros\models\ModelInfoTrait {
		handyFieldValues as trait_handyFieldValues;
	}
/*>>>>>CLASS*/
/*<<<<<STATIC_INFO*/
	public static function tableName()
	{
		return '{{%countries}}';
	}
	public static $relations = [
		'places' => [ 'model' => 'Place', 'left' => 'countries.id', 'right' => 'places.countries_id', 'modelClass' => 'santilin\wrepos\models\Place', 'relatedTablename' => 'places', 'join' => 'countries.id = places.countries_id', 'type' => 'BelongsToMany'],
	];
/*>>>>>STATIC_INFO*/
/*<<<<<FIND_IF_NOT_QUERY*/
	/**
	 * @return \santilin\wrepos\models\comp\CountryQuery the active query used by this AR class.
	 */
	public static function find()
	{
		if (class_exists("santilin\wrepos\models\comp\CountryQuery")) {
			$q = new \santilin\wrepos\models\comp\CountryQuery(get_called_class());
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
		return Yii::$app->getModule('wrepos')->db;
	}

/*<<<<<MODEL_INFO*/
	public static bool $isJunctionModel = false;
	protected static array $_model_info = [];
	public static function getModelInfo($part)
	{
		if (static::$_model_info == []) {
			$mi = [
				'model_name' => 'Country',
				'title' => 'Country',
				'title_plural' => 'Countrys',
				'code_field' => 'iso2',
				'desc_field' => 'name',
				'controller_name' => 'country',
				'female' => true,
				'record_desc_format_short' => '{iso2}',
				'record_desc_format_medium' => '{iso2}, {name}',
				'record_desc_format_long' => '{iso2}, {name}, {name_es}, {name_en}, {name_fr}',
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
			'iso2' => 'Iso2',
			'iso3' => 'Iso3',
			'name' => 'Name',
			'name_es' => 'Name es',
			'name_en' => 'Name en',
			'name_fr' => 'Name fr',
			'places' => Place::getModelInfo('title_plural'), // belongstomany
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
			'req' => [['iso2','iso3'], 'required'],
			'max_iso2' => ['iso2', 'string', 'max' => 2],
			'max_iso3' => ['iso3', 'string', 'max' => 3],
			'null' => [['name','name_es','name_en','name_fr'], 'default', 'value' => null],
		];
/*>>>>>RULES*/
		// customize your rules here

/*<<<<<RULES_RETURN*/
		return $rules;
	} // rules
/*>>>>>RULES_RETURN*/
/*<<<<<HANDY_VALUES*/
	public function handyFieldValues(
		string $field,
		string $format,
		string $model_format = 'medium',
		array|string|null $scope = null,
		?string $filter_fields = null,
	) {
		$field_parts = explode('.', $field);
		if (count($field_parts) > 1) {
			$table = array_shift($field_parts);
			$rel_model_name = static::$relations[$table]['modelClass'];
			$rel_model = new $rel_model_name();
			return $rel_model->handyFieldValues(implode('.', $field_parts), $format, $model_format, $scope, $filter_fields);
		}
		$ret = null;
/*>>>>>HANDY_VALUES*/
/*<<<<<HANDY_VALUES.BODY*/
		if ($field == 'places') { // hasMany
			$q = Place::find();
			static::applyScopes($q, $scope);
			$models = $q->all();
			$ret = [];
			if (empty($filter_fields)) {
				foreach ($models as $model) {
					$ret[$model->getPrimaryKey()] = $model->recordDesc($model_format);
				}
			} else {
				$fflds = explode(',', $filter_fields);
				foreach ($models as $model) {
					$ret[$model->getPrimaryKey()] = array_merge([$model->recordDesc($model_format)], $model->getAttributeValues($fflds));
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
	public function getPlaces() // HasMany
	{
		return $this->hasMany(
			Place::class,
			['countries_id' => 'id'],
		);
	}
/*>>>>>RELATIONS*/

	static public function getDb()
	{
		return Yii::$app->getModule('wrepos')->db;
	}

/*<<<<<END*/
} // class Country
/*>>>>>END*/

