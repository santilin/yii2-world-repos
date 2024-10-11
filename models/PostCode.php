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
 * This is the base model class for table "{{%postcodes}}".
 *
 * @property string $postcode // places/postcode
 * @property integer $places_id
 *
 * @property santilin\wrepos\models\Place $place // HasOne
 */
class PostCode extends \santilin\wrepos\models\_BaseModel
{
	use \santilin\churros\RelationTrait;
	use \santilin\churros\models\ModelInfoTrait {
		handyFieldValues as trait_handyFieldValues;
	}
/*>>>>>CLASS*/
/*<<<<<STATIC_INFO*/
	static public function tableName()
	{
		return '{{%postcodes}}';
	}
	static public $relations = [
'place' => [ 'model' => 'Place', 'left' => 'postcodes.places_id', 'right' => 'places.id', 'modelClass' => 'santilin\wrepos\models\Place', 'relatedTablename' => 'places', 'join' => 'postcodes.places_id = places.id', 'type' => 'HasOne']
	];
/*>>>>>STATIC_INFO*/
/*<<<<<MODEL_INFO*/
	static public $_model_info = [];
	static public function getModelInfo($part)
	{
		if (static::$_model_info == [] ) {
			$mi = [
				'model_name' => 'PostCode',
				'title' => 'PostCode',
				'title_plural' => 'PostCodes',
				'code_field' => '',
				'desc_field' => 'postcode',
				'controller_name' => 'post-code',
				'female' => true,
				'record_desc_format_short' => '',
				'record_desc_format_medium' => '',
				'record_desc_format_long' => ''
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
     * @return \santilin\wreposforms\PostCodeQuery the active query used by this AR class.
     */
    static public function find()
    {
		if( class_exists("santilin\wrepos\models\comp\PostCodeQuery") ) {
			return new \santilin\wrepos\models\comp\PostCodeQuery(get_called_class());
		} else {
			return parent::find();
		}
    } // find
/*>>>>>FIND*/
/*<<<<<LABELS*/
	public function attributeLabels()
	{
		$labels = [
			'postcode' => 'Postcode',
			'places_id' => Place::getModelInfo('title'), // HasOne
			'place' => Place::getModelInfo('title'), // HasOne
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
			'req' => [['postcode','places_id'], 'required', 'on' => $this->getCrudScenarios()],
			'int_places_id' => ['places_id', 'integer', 'min' => -2147483648, 'max' => 2147483647, 'on' => $this->getCrudScenarios()],
			'max_postcode'=>['postcode', 'string', 'max' => 10, 'on' => $this->getCrudScenarios()],
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
		if( $field == 'places_id' || $field == 'place' || $field == 'Place' ) { // HasOne
			$q = Place::find();
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
	/**
	 * The keys of the array refer to the attributes of the record associated with the `$class` model,
	 * while the values of the array refer to the corresponding attributes in **this** AR class.
	 */
	public function getPlace()
	{
		// PostCode.place:HasOne(not null) Place: postcodes.places_id=>places.id
		return $this->hasOne(\santilin\wrepos\models\Place::class,
			['id'=>"places_id"]);
	}
/*>>>>>RELATIONS*/

	static public function findPlacePostCode(int $places_id): string
	{
		$postcode = PostCode::findOne(['places_id' => $places_id]);
		if ($postcode) {
			return $postcode->postcode;
		} else {
			$sup_place = Place::findSupPlaceById($places_id);
			if ($sup_place) {
				return self::findPlacePostCode($sup_place->id);
			}
		}
		return '';
	}


/*<<<<<END*/
} // class PostCode
/*>>>>>END*/
