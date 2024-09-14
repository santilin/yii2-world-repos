<?php
/*<<<<<USES*/
/*Template:Yii2App/models/ModelQuery.php*/
namespace santilin\wrepos\models\comp;

use Yii;
use yii\db\ActiveQuery;
use santilin\wrepos\models\PostCode;
/*>>>>>USES*/
/*<<<<<CLASS*/
class PostCodeQuery extends ActiveQuery 
{
/*>>>>>CLASS*/
/*<<<<<DEFAULT_ORDER*/
	// Used in handyValues to sort select lists
	public function defaultOrder()
	{
/*>>>>>DEFAULT_ORDER*/
/*<<<<<DEFAULT_ORDER_RETURN*/
		return $this;
	}
/*>>>>>DEFAULT_ORDER_RETURN*/
/*<<<<<END*/
} // PostCodeQuery
/*>>>>>END*/
