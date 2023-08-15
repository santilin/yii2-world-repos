<?php
/*<<<<<USES*/
/*Template:Yii2App/controllers/EmptyController.php*/
namespace santilin\wrepos\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use santilin\wrepos\models\Place;
/**
 * PlaceController an empty controller.
 */
class PlaceController extends Controller
{
	/**
	 * @var $layout The layout for this controller
	 */
	public $layout = 'main';
	/**
	 * @inheritdoc
	 */
    public $enableCsrfValidation = false;
/*>>>>>USES*/

	public function actionFindPostCode(string $place, string $country_code)
	{
		$models = Place::find()->where(['LIKE', 'name', $place])->asArray()->all();
		return $models;
	}

/*<<<<<CLASS_END*/
} // class SiteController
/*>>>>>CLASS_END*/
