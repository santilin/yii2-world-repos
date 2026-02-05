<?php
/*<<<<<USES*/
/*Template:Yii2App/models/DbRecordModel.php*/

declare(strict_types=1);

namespace santilin\wrepos\models;

use santilin\wrepos\models\{Place};
use santilin\wrepos\models\_BaseModel as Base_PostCode;
/*>>>>>USES*/
use Yii;
/*<<<<<CLASS*/
/**
 * This is the base model class for table `{{%postcodes}}`.
 *
 * @property string $postcode // places/postcode
 * @property integer $places_id
 * @property \santilin\wrepos\models\Place $place // HasOne
 */
class PostCode extends Base_PostCode
{
	use \santilin\churros\RelationTrait;
	use \santilin\churros\models\ModelInfoTrait;
/*>>>>>CLASS*/
/*<<<<<STATIC_INFO*/
	public static function tableName()
	{
		return '{{%postcodes}}';
	}
	/**
	 * @var array<string, array<string, string>>
	 */
	public static $relations = [
		'place' => [ 'model' => 'Place', 'left' => 'postcodes.places_id', 'right' => 'places.id', 'modelClass' => 'santilin\wrepos\models\Place', 'relatedTablename' => 'places', 'join' => 'postcodes.places_id = places.id', 'type' => 'HasOne'],
	];
/*>>>>>STATIC_INFO*/
/*<<<<<FIND_IF_NOT_QUERY*/
	/**
	 * @return \santilin\wrepos\models\comp\PostCodeQuery the active query used by this AR class.
	 */
	public static function find()
	{
		if (class_exists("santilin\wrepos\models\comp\PostCodeQuery")) {
			$q = new \santilin\wrepos\models\comp\PostCodeQuery(get_called_class());
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
	public static function getModelInfo($part): string|bool
	{
		if (static::$_model_info === []) {
			$mi = [
				'model_name' => 'PostCode',
				'title' => 'Post code',
				'title_plural' => 'Post codes',
				'code_field' => '',
				'desc_field' => 'postcode',
				'controller_name' => 'post-code',
				'female' => true,
				'record_desc_format_short' => '{}',
				'record_desc_format_medium' => '{}',
				'record_desc_format_long' => '{}',
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
			'req' => [['postcode','places_id'], 'required'],
			'max_postcode' => ['postcode', 'string', 'max' => 10],
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
			if ($field === 'place') { // HasOne
				$q = Place::find();
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
	public function getPlace() // HasOne
	{
		// PostCode.place:HasOne(not null) Place: postcodes.places_id=>places.id
		return $this->hasOne(
			Place::class,
			['id' => 'places_id'],
		);
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

	static public function searchPostCodes(string $search, int $page = 1, int $per_page = 10): array
	{
		$models = [];
		$search = trim($search);
		$postcode_tbl = PostCode::tableName();
		$place_tbl = Place::tableName();
		$sql = '';
		if ($per_page != 0) {
			if ($page == 0 ) {
				$page = 1;
			}
			$sql_limit = ' LIMIT ' . ($page-1) * $per_page . ",$per_page";
		}
		if (is_numeric($search) ) {
			if (strlen($search)>=4) {
// 				$sql = <<<SQL
// SELECT pc.postcode, plpr.name as nuts3, pl.name as nuts4, '' as nuts5, substr(pc.postcode,1,2) as nuts3_code
// FROM $postcode_tbl pc
// 	INNER JOIN $place_tbl pl ON pl.id=pc.places_id
// 	LEFT JOIN $place_tbl plpr ON pl.admin_sup_code=plpr.admin_code AND plpr.level = 3
// WHERE pc.postcode LIKE :postcode_like AND pl.level = 4 /* :place_like */
// UNION
// SELECT pc.postcode, plpr.name, plmun.name, pl.name, substr(pc.postcode,1,2)
// FROM $postcode_tbl pc
// 	INNER JOIN $place_tbl pl ON pl.id=pc.places_id
// 	LEFT JOIN $place_tbl plmun ON pl.admin_sup_code=plmun.admin_code AND plmun.level = 4
// 	LEFT JOIN $place_tbl plpr ON plmun.admin_sup_code=plpr.admin_code AND plpr.level = 3
// WHERE pc.postcode LIKE :postcode_like AND pl.level >= 5
// SQL;
				$sql = <<<SQL
WITH RECURSIVE descendants AS (
    -- ANCHOR: Level 4 places from postcodes (matches your first UNION)
    SELECT
		pl.id as place_id,
        pc.postcode,
        COALESCE(plpr.name, '') as nuts3,
        pl.name as nuts4,
        '' as nuts5,
        substr(pc.postcode,1,2) as nuts3_code,
        pl.level,
        pl.admin_code,
        pl.admin_sup_code
    FROM $postcode_tbl pc
    INNER JOIN $place_tbl pl ON pl.id=pc.places_id
    LEFT JOIN $place_tbl plpr ON pl.admin_sup_code=plpr.admin_code AND plpr.level = 3
    WHERE pc.postcode LIKE :postcode_like AND pl.level = 4

    UNION ALL

    -- RECURSIVE: Levels 5+ with path building (matches your second UNION)
    SELECT
		pl_child.id as place_id,
        d.postcode,
        d.nuts3,
        d.nuts4,
        CASE
            WHEN d.nuts5 = '' THEN pl_child.name
            ELSE d.nuts5 || ' - ' || pl_child.name
        END as nuts5,
        d.nuts3_code,
        pl_child.level,
        pl_child.admin_code,
        pl_child.admin_sup_code
    FROM descendants d
    INNER JOIN $place_tbl pl_child ON pl_child.admin_sup_code = d.admin_code
    WHERE pl_child.level > 4
)
SELECT place_id, postcode, nuts3, nuts4, nuts5, nuts3_code, level
FROM descendants
ORDER BY postcode, level
SQL;
				$models = PostCode::getDb()->createCommand($sql. $sql_limit)
					->bindValue(':postcode_like', $search . '%')
					->queryAll();
			}
			return $models;
		} else {
				$sql = <<<SQL
SELECT pl.id as place_id, plpr.name as nuts3, pl.name as nuts4, '' as nuts5
	FROM $place_tbl pl
		INNER JOIN $place_tbl plpr ON pl.admin_sup_code=plpr.admin_code AND plpr.level = 3
	WHERE (pl.name LIKE :place_like) AND pl.level = 4
	UNION
	SELECT pl.id, plpr.name, plmun.name, pl.name
	FROM $place_tbl pl
		INNER JOIN $place_tbl plmun ON pl.admin_sup_code=plmun.admin_code AND plmun.level = 4
		INNER JOIN $place_tbl plpr ON plmun.admin_sup_code=plpr.admin_code AND plpr.level = 3
	WHERE (pl.name LIKE :place_like) AND pl.level = 5
	UNION
	SELECT pl.id, plpr.name, plmun.name, plent.name || ' - ' || pl.name
	FROM $place_tbl pl
		INNER JOIN $place_tbl plent ON pl.admin_sup_code=plent.admin_code AND plent.level = 5
		INNER JOIN $place_tbl plmun ON plent.admin_sup_code=plmun.admin_code AND plmun.level = 4
		INNER JOIN $place_tbl plpr ON plmun.admin_sup_code=plpr.admin_code AND plpr.level = 3
	WHERE (pl.name LIKE :place_like) AND pl.level = 6
UNION
	SELECT pl.id, plpr.name, plmun.name, plent.name || ' - ' || plsubent.name || ' - '  || pl.name
	FROM $place_tbl pl
	INNER JOIN $place_tbl plent ON pl.admin_sup_code=plsubent.admin_code AND plsubent.level = 6
	INNER JOIN $place_tbl plsubent ON plsubent.admin_sup_code=plent.admin_code AND plent.level = 5
	INNER JOIN $place_tbl plmun ON plent.admin_sup_code=plmun.admin_code AND plmun.level = 4
	INNER JOIN $place_tbl plpr ON plmun.admin_sup_code=plpr.admin_code AND plpr.level = 3
	WHERE (pl.name LIKE :place_like) AND pl.level > 6

ORDER BY nuts3, nuts4, nuts5
SQL;
			$places = PostCode::getDb()->createCommand($sql)
					->bindValue(':place_like', "%$search%")
					->queryAll();
			foreach ($places as $place) {
				$postcode = PostCode::findPlacePostCode(intval($place['place_id']));
				$place['nuts3'] = '(' . $place['nuts3'] . ')';
				$place['postcode'] = $postcode;
				// $place['nuts4'] not changed
				$place['nuts3_code'] = substr($place['postcode'],0,2);
				$place['nuts5'] = str_replace('|', ', ', $place['nuts5']);
				if ($postcode) {
					$k = $postcode . '-' . $place['nuts4'] . '-' . $place['nuts5'];
					if (isset($models[$k])) {
						continue;
					}
					$models[$k] = $place;
				} else {
					$models[] = $place;
				}
			}
			return array_values($models);
		}
	}

/*<<<<<END*/
} // class PostCode
/*>>>>>END*/
