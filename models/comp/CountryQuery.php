<?php
/*<<<<<USES*/
/*Template:Yii2App/models/ModelQuery.php*/
namespace santilin\wrepos\models\comp;

use Yii;
use yii\db\ActiveQuery;
use santilin\wrepos\models\Country;
/*>>>>>USES*/
/*<<<<<CLASS*/
class CountryQuery extends ActiveQuery
{
	// Used in handyValues to sort select lists
	public function defaultOrder()
	{
		$this->orderBy('iso2');
/*>>>>>CLASS*/
/*<<<<<DEFAULT_ORDER_RETURN*/
		return $this;
	}
/*>>>>>DEFAULT_ORDER_RETURN*/

	public function byIso2(string $iso2)
	{
		return $this->andWhere(['iso2' => $iso2]);
	}

/*<<<<<END*/
} // CountryQuery
/*>>>>>END*/
