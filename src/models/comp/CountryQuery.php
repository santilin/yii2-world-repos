<?php
/*<<<<<MAIN*/
namespace app\models\comp;

use yii\db\ActiveQuery;
use app\models\Country;
/*>>>>>MAIN*/
/*<<<<<CLASS*/
class CountryQuery extends ActiveQuery
{
	// Add your scopes here

	public function defaultOrder()
	{
		$this->orderBy('iso2');
/*>>>>>CLASS*/
/*<<<<<DEFAULT_ORDER_RETURN*/
		return $this;
	}
/*>>>>>DEFAULT_ORDER_RETURN*/
/*<<<<<END*/
} // CountryQuery
/*>>>>>END*/
