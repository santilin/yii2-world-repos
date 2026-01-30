<?php
/*<<<<<USES*/
/*Template:Yii2App/models/ModelSearch.php*/
namespace santilin\wrepos\forms;

use santilin\wrepos\models\Place;
use santilin\churros\models\ModelInfoTrait;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
/*>>>>>USES*/
/*<<<<<CLASS*/
/**
 * santilin\wrepos\forms\Place_Search represents the model behind the search form about `santilin\wrepos\models\Place`.
 */
class Place_Search extends Place
{
	use \santilin\churros\models\ModelSearchTrait;
/*>>>>>CLASS*/
/*<<<<<CLASS_BODY*/
	protected $related_properties = [
		'country' => null,
		'postCodes' => null,
	];
	protected $related_operators = [
		'country' => 'LIKE',
		'postCodes' => 'LIKE',
	];
	protected $attrs_operators = [
		'admin_code' => 'LIKE',
		'admin_sup_code' => 'LIKE',
		'admin_sup_name' => 'LIKE',
		'countries_id' => '=',
		'id' => '=',
		'level' => '=',
		'name' => 'LIKE',
		'name_en' => 'LIKE',
		'name_es' => 'LIKE',
		'name_fr' => 'LIKE',
		'national_id' => 'LIKE',
	];
/*>>>>>CLASS_BODY*/
/*<<<<<SCENARIOS*/
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
/*>>>>>SCENARIOS*/
/*<<<<<RULES*/
	/**
	* @inheritdoc
	*/
	public function rules()
	{
		$rules = [
			'safe' => [['country','postCodes','admin_code','admin_sup_code','admin_sup_name','countries_id','id','level','name','name_en','name_es','name_fr','national_id'], 'safe'],
		];
		// add your custom rules below
/*>>>>>RULES*/
/*<<<<<RULES.RETURN*/
		return $rules;
	}
/*>>>>>RULES.RETURN*/
/*<<<<<SEARCH*/
	/**
     * Creates a data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
		$query = null;
		$searchRelation = ArrayHelper::remove($params, '_search_relation', false);
		if ($searchRelation !== false) {
			/** @var callable(): \yii\db\ActiveQuery $searchRelation */
			$searchRelation = "get" . ucfirst($searchRelation);
			if (method_exists($this, $searchRelation)) {
				$query = call_user_func([$this, $searchRelation]);
			} elseif (isset($params['master'])) {
				if (true) { /// @todo this relation is generic {
					$query = call_user_func([$params['master'], $searchRelation]);
				} else {
					$junction_query = call_user_func([$params['master'], $searchRelation]);
					if ($junction_query->via) {
						$query = $junction_query->via[1];
					}
				}
			}
		}
		if (!$query) {
			$query = Place::find();
		}
		$searchScopes = (array) ArrayHelper::remove($params, '_search_scopes', []);
		static::applyScopes($query, $searchScopes, false);
		if ($params['or'] ?? false) {
			unset($params['or']);
			$is_or = true;
		} else {
			$is_or = false;
		}
        $dataProvider = new ActiveDataProvider($params['dataProvider'] ?? []);
		$dataProvider->query = $query;
/*>>>>>SEARCH*/
/*<<<<<SEARCH.LOAD*/
        $this->load($params);
		if ($dataProvider->pagination) {
 			$this->_gridPageSize = intval($dataProvider->pagination->pageSize = $params['per-page'] ?? Yii::$app->session->get('GridPageSize', 12));
 			if ($this->_gridPageSize !== 0 && $this->_gridPageSize !== 999999999) { // dont store All in session
 				Yii::$app->session->set('GridPageSize', $dataProvider->pagination->pageSize);
 			}
		}
		// set if you do want to return any records when validation fails
		$no_results_if_validation_fails = false;
/*>>>>>SEARCH.LOAD*/
/*<<<<<SEARCH_VALIDATE*/
        if ($no_results_if_validation_fails) {
            if (!$this->validate()) {
				$query->where('0=1');
				return $dataProvider;
			}
		}
		$conditions = [];
/*>>>>>SEARCH_VALIDATE*/
/*<<<<<SEARCH_FILTERS*/
		foreach ($this->attrs_operators as $attr => $operator) {
			$v = $this->__get($attr);
			if (isset($v['op']) && isset($v['v'])) {
				$conditions[] = $this->searchFilterWhere($attr, $v);
			} else {
				$conditions[] = $this->searchFilterWhere($attr,
					['op' => $operator, 'v' => $this->__get($attr)]);
			}
		}
		foreach ($this->related_properties as $attr => $value) {
			$conditions[] = $this->filterWhereRelated($query, $attr, $value);
		}
		if ($is_or) {
			$query->andWhere(array_merge(['or'], array_filter($conditions)));
		} else {
			$query->andWhere(array_merge(['and'], array_filter($conditions)));
		}
/*>>>>>SEARCH_FILTERS*/
/*<<<<<DEFAULT_SORT*/
		if ($dataProvider->query->orderBy === null || count($dataProvider->query->orderBy) === 0) {
			$dataProvider->sort->defaultOrder = ['countries_id' => SORT_ASC];
		}
/*>>>>>DEFAULT_SORT*/
/*<<<<<SEARCH_SORTS*/
		$dataProvider->sort->attributes['countries_id'] = [
			'asc' => [ 'countries_id' => SORT_ASC ],
			'desc' => [ 'countries_id' => SORT_DESC ],
		];
		$dataProvider->sort->attributes['country'] = [
			'asc' => [ 'as_country.iso2' => SORT_ASC ],
			'desc' => [ 'as_country.iso2' => SORT_DESC ],
		];
/*>>>>>SEARCH_SORTS*/
/*<<<<<SEARCH_RETURN*/
		return $dataProvider;
	}
/*>>>>>SEARCH_RETURN*/
/*<<<<<SEARCH_END*/
} // class Place_Search
/*>>>>>SEARCH_END*/
