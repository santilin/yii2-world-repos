<?php
/*<<<<<USES*/
namespace app\models\comp;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use santilin\churros\ModelSearchTrait;
use santilin\churros\helpers\FormHelper;
use app\models\Country;
/*>>>>>USES*/
/*<<<<<CLASS*/
/**
 * \app\models\comp\CountrySearch represents the model behind the search form about `\app\models\Country`.
 */
class CountrySearch extends Country
{
	use \santilin\churros\ModelSearchTrait {
		addFieldFilterToQuery as parentAddFieldFilterToQuery;
	}

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
/*>>>>>CLASS*/
/*<<<<<RULES*/
	/**
		* @inheritdoc
		*/
	public function rules()
	{
		$rules = [
			'safe'=>[['iso2','iso3','name'], 'safe'],
		];
		if( YII_DEBUG ) {
			$rules['prim_key'] = [['id'], 'safe'];
		}
/*>>>>>RULES*/
		// add your rules here
/*<<<<<RULES_RETURN*/
        return array_merge(parent::rules(), $this->dynamic_rules, $rules);
    }
/*>>>>>RULES_RETURN*/
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
        $query = Country::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
		// set if you do want to return any records when validation fails
        $no_results_if_validation_fails = false;
/*>>>>>SEARCH*/
/*<<<<<SEARCH_VALIDATE*/
        if ($no_results_if_validation_fails ) {
            if (!$this->validate()) {
				$query->where('0=1');
			}
			return $dataProvider;
		}
		foreach( $this->attributes as $name => $value ) {
			$this->filterWhere($query, $name, $value);
		}
		foreach( $this->related_properties as $name => $value ) {
			$this->filterWhereRelated($query, $name, $value);
		}
/*>>>>>SEARCH_VALIDATE*/
/*<<<<<DEFAULT_SORT*/
		$dataProvider->sort->defaultOrder = [ 'iso2' => SORT_ASC ];
/*>>>>>DEFAULT_SORT*/
/*<<<<<SEARCH_RETURN*/
		return $dataProvider;
	}
/*>>>>>SEARCH_RETURN*/
/*<<<<<REPORT_COLUMNS*/
	static public function allReportColumns($relname = null)
	{
		if( $relname === null ) {
			$relname = 'countries';
		}
		$ret = [
			"$relname.id" => [ // tinyInteger
				'hAlign' => 'right',
				'format' => 'raw',
			],
			"$relname.iso2" => [ // string
			],
			"$relname.iso3" => [ // string
			],
			"$relname.name" => [ // string
			],
		];
/*>>>>>REPORT_COLUMNS*/
		// Tweak or add report fields here
/*<<<<<REPORT_COLUMNS_END*/
		return $ret;
	}
/*>>>>>REPORT_COLUMNS_END*/
/*<<<<<SEARCH_FIELDS*/
	public function allSearchFields($visible_fields, $excluded_fields = [], $relname = null, $parent = null)
	{
		if( $parent == null ) {
			$parent = $this;
		}
		if( $relname == null ) {
			$relname = '';
		} else {
			$relname .= '.';
		}
		$cef = count($excluded_fields);
		$cvf = count($visible_fields);
		if( !$cef || ($cef && !in_array('iso2', $excluded_fields)) ) {
			$sf[$relname . 'iso2'] = $parent->createSearchField($relname . 'iso2', 'string',
				['visible'=>!$cvf || in_array('iso2', $visible_fields)]);
			unset($excluded_fields['iso2']);
			unset($visible_fields['iso2']);
		}

		if( !$cef || ($cef && !in_array('iso3', $excluded_fields)) ) {
			$sf[$relname . 'iso3'] = $parent->createSearchField($relname . 'iso3', 'string',
				['visible'=>!$cvf || in_array('iso3', $visible_fields)]);
			unset($excluded_fields['iso3']);
			unset($visible_fields['iso3']);
		}

		if( !$cef || ($cef && !in_array('name', $excluded_fields)) ) {
			$sf[$relname . 'name'] = $parent->createSearchField($relname . 'name', 'string',
				['visible'=>!$cvf || in_array('name', $visible_fields)]);
			unset($excluded_fields['name']);
			unset($visible_fields['name']);
		}
/*>>>>>SEARCH_FIELDS*/
		// Tweak or add search fields here
/*<<<<<SEARCH_FIELDS_END*/
		return $sf;
	}
/*>>>>>SEARCH_FIELDS_END*/
/*<<<<<SEARCH_END*/
} // class CountrySearch
/*>>>>>SEARCH_END*/

