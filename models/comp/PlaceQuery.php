<?php
/*<<<<<USES*/
/*Template:Yii2App/models/ModelQuery.php*/
namespace santilin\wrepos\models\comp;

use Yii;
use yii\db\ActiveQuery;
use santilin\wrepos\models\Place;
/*>>>>>USES*/
/*<<<<<CLASS*/
class PlaceQuery extends ActiveQuery
{
	// Used in handyValues to sort select lists
	public function defaultOrder()
	{
		$this->orderBy('name');
/*>>>>>CLASS*/
/*<<<<<DEFAULT_ORDER_RETURN*/
		return $this;
	}
/*>>>>>DEFAULT_ORDER_RETURN*/
/*<<<<<MINE_SCOPE*/
	public function mine($model = null)
	{
/*>>>>>MINE_SCOPE*/
/*<<<<<MINE_SCOPE.RETURN*/
		return $this;
	}
/*>>>>>MINE_SCOPE.RETURN*/


	public function byCountryId(int $country_id)
	{
		return $this->andWhere(['countries_id' => $country_id]);
	}

	public function byNutsCode(string $nuts_code)
	{
		return $this->andWhere(['nuts_code' => $nuts_code]);
	}

/*<<<<<END*/
} // PlaceQuery
/*>>>>>END*/
