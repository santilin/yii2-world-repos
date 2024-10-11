<?php
/*<<<<<USES*/
/*Template:Yii2App/models/ModelSearch.php*/
namespace santilin\wreposforms;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use santilin\wrepos\models\Place;
/*>>>>>USES*/
/*<<<<<CLASS*/
/**
 * \santilin\wreposforms\Place_Search represents the model behind the search form about `\santilin\wrepos\models\Place`.
 */
class Place_Search extends Place
{
/*>>>>>CLASS*/
/*<<<<<CLASS_BODY*/
	use \santilin\churros\models\ModelSearchTrait;
protected $related_properties = [
		'country.id' => null,
	];
protected $normal_attrs = [
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
			'safe'=>[['country','country.id','postCodes','admin_code','admin_sup_code','admin_sup_name','countries_id','id','level','name','name_en','name_es','name_fr','national_id'], 'safe'],
		];
		// add your custom rules below
/*>>>>>RULES*/
/*<<<<<RULES.RETURN*/
		return $rules;
	}
/*>>>>>RULES.RETURN*/
/*<<<<<ATTRIBUTE_LABELS*/
	public function attributeLabels()
	{
		$labels = [
			'country.id' => \santilin\wrepos\models\Country::instance()->getModelInfo('title'),
		];
/*>>>>>ATTRIBUTE_LABELS*/
		// customize your labels here
/*<<<<<ATTRIBUTE_LABELS.RETURN*/
        return array_merge(parent::attributeLabels(), $labels);
	} // attributeLabels
/*>>>>>ATTRIBUTE_LABELS.RETURN*/
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
		$query = Place::find();
		$searchRelations = (array)ArrayHelper::remove($params, '_search_relations', []);
		foreach ($searchRelations as $relation) {
			$query->joinWith($relation);
		}
		$searchScopes = (array)ArrayHelper::remove($params, '_search_scopes', []);
		foreach( $searchScopes as $scope ) {
			$query->$scope();
		}
		if (!empty($params['or'])) {
			unset($params['or']);
			$is_or = true;
		} else {
			$is_or = false;
		}
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
/*>>>>>SEARCH*/
/*<<<<<SEARCH.LOAD*/
        $this->load($params);
		if( $dataProvider->pagination ) {
 			$this->_gridPageSize = $dataProvider->pagination->pageSize = $params['per-page']??Yii::$app->session->get('GridPageSize', 12);
 			if( $this->_gridPageSize != 0 ) { // dont store All in session
 				Yii::$app->session->set('GridPageSize', $dataProvider->pagination->pageSize);
 			}
		}
		// set if you do want to return any records when validation fails
		$no_results_if_validation_fails = false;
/*>>>>>SEARCH.LOAD*/
/*<<<<<SEARCH_VALIDATE*/
        if ($no_results_if_validation_fails ) {
            if (!$this->validate()) {
				$query->where('0=1');
				return $dataProvider;
			}
		}
/*>>>>>SEARCH_VALIDATE*/
/*<<<<<SEARCH_FILTERS*/
		foreach( $this->normal_attrs as $attr => $operator ) {
			$this->searchFilterWhere($query, $attr, ['op' => $operator, 'v' => $this->$attr], !$is_or);
		}
		foreach( $this->related_properties as $attr => $value ) {
			$this->filterWhereRelated($query, $attr, $value, !$is_or);
		}
/*>>>>>SEARCH_FILTERS*/
/*<<<<<DEFAULT_SORT*/
		$dataProvider->sort->defaultOrder = ['countries_id' => SORT_ASC];
/*>>>>>DEFAULT_SORT*/
/*<<<<<SEARCH_SORTS*/
		$dataProvider->sort->attributes['country.id'] = [
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
