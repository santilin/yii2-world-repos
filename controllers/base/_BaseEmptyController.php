<?php
/*<<<<<USES*/
/*Template:Yii2App/controllers/base/_BaseEmptyController.php*/
namespace santilin\wrepos\controllers\base;

use Yii;
use yii\web\Controller as BaseController;
/*>>>>>USES*/
/*<<<<<CLASS*/
/**
 *  _BaseEmptyController
 */
class _BaseEmptyController extends BaseController
{
	public $layout = 'site'; /// override
	public $breadCrumbsStyle = ["standard"];
/*>>>>>CLASS*/
/*<<<<<BEHAVIORS*/
	public function behaviors()
	{
		$b = parent::behaviors();
/*>>>>>BEHAVIORS*/
/*<<<<<BEHAVIORS_END*/
		return $b;
	}
/*>>>>>BEHAVIORS_END*/
/*<<<<<CLASS_END*/
} // _BaseEmptyController
/*>>>>>CLASS_END*/
