<?php
/*<<<<<USES*/
/*Template:Yii2App/controllers/EmptyController.php*/
namespace santilin\wrepos\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use santilin\wrepos\models\Place;
/*>>>>>USES*/
/*<<<<<CLASS*/
/**
 * PlaceController an empty controller.
 */
class PlaceController extends Controller
{
	/**
	 * @var $layout The layout for this controller
	 */
	public $layout = 'site';
/*>>>>>CLASS*/

	public function actionFindPlace(string $place, string $country_code)
	{
		\Yii::$app->response->format = Response::FORMAT_JSON;
		$models = Place::find()->where(['LIKE', 'name', $place])->asArray()->all();
		return $models;
	}

	public function actionFindDegurba(string $mun_id, string $country = 'ES')
	{
		$p = new Place; // to get the db object
		$db = p->getDb();
		$db->createCommand("SELECT * FROM entidades_es WHERE INEMUNI = ?", [$mun_id])
				->queryAll();
		return $db;
	}


/*<<<<<CLASS_END*/
} // class SiteController
/*>>>>>CLASS_END*/
