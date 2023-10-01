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
	use \santilin\churros\ModelInfoTrait;
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
/*<<<<<LABELS_RETURN*/
 		return $labels;
	} // attributeLabels
/*>>>>>LABELS_RETURN*/
/*<<<<<RULES*/
    public function rules()
    {
		$rules = [
			'req' => [['postcode','places_id'], 'required', 'on' => $this->getCrudScenarios()],
			'max_postcode'=>['postcode', 'string', 'max' => 10, 'on' => $this->getCrudScenarios()],
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
		if( $field == 'places_id' || $field == 'place' || $field == 'Place' ) { // HasOne
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
			$relname = 'postcodes';
		}
		$ret = [

			"$relname.postcode" => [ // string
				'format' => 'raw',
			],
			"$relname.places_id" => [ // HasOne
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
	public function getPlace()
	{
		// place:PostCode HasOne(not null) Place: postcodes.places_id=>places.id
		return $this->hasOne(\santilin\wrepos\models\Place::class, ['id' => 'places_id']);
	}
/*>>>>>RELATIONS*/
/*<<<<<END*/
} // class PostCode
/*>>>>>END*/
