<?php
/*<<<<<USES*/
/*Template:Yii2App/controllers/EmptyController.php*/
namespace santilin\wrepos\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use santilin\wrepos\models\PostCode;
/*>>>>>USES*/
use santilin\wrepos\models\Place;

/*<<<<<CLASS*/
/**
 * PostCodeController an empty controller.
 */
class PostCodeController extends Controller
{
	/**
	 * @var $layout The layout for this controller
	 */
	public $layout = 'main';
/*>>>>>CLASS*/

	// Cant use Query because postcode has no id
// 	public function actionFind(string $search, int $page = 1, int $per_page = 5)
// 	{
// 		if( !$page) {
// 			$page = 1;
// 		}
// 		\Yii::$app->response->format = Response::FORMAT_JSON;
// 		$sql = "SELECT pc.postcode as id, pc.postcode, pl.name FROM "
// 		. PostCode::tableName() . 'pc INNER JOIN '
// 		. Place::tableName() . 'pl ON pl.id=pc.places_id'
// 		. " WHERE pc.postcode = :postcode OR pl.name LIKE :postcode_like";
// 		if ($page) {
// 			$sql .= ' LIMIT ' . ($page-1) * $per_page . ",$per_page";
// 		}
// 		$models = PostCode::getDb()->createCommand($sql)
// 			->bindValue(':postcode', $search)
// 			->bindValue(':postcode_like', $search . '%')
// 			->queryAll();
// 		return  [ 'items' => $models, 'total_count' => 20 ];
// 	}
//
	public function actionFindTypeAhead(string $search, int $page = 1, int $per_page = 5)
	{
		if( !$page) {
			$page = 1;
		}
		\Yii::$app->response->format = Response::FORMAT_JSON;
		$sql = "SELECT pc.postcode as id, pc.postcode, pl.name FROM "
		. PostCode::tableName() . 'pc INNER JOIN '
		. Place::tableName() . 'pl ON pl.id=pc.places_id'
		. " WHERE pc.postcode = :postcode OR pl.name LIKE :postcode_like";
		if ($page) {
			$sql .= ' LIMIT ' . ($page-1) * $per_page . ",$per_page";
		}
		$models = PostCode::getDb()->createCommand($sql)
			->bindValue(':postcode', $search)
			->bindValue(':postcode_like', $search . '%')
			->queryAll();
		$ret = [];
		foreach ($models as $model) {
			$ret[] = [ 'value' => $model['name'], 'id' => $model['id'] ];
		}
		return $ret;
	}




	// Cant use Query because postcode has no id
	public function actionFindPostCode(string $postcode, string $country_code)
	{
		\Yii::$app->response->format = Response::FORMAT_JSON;
		$models = PostCode::getDb()->createCommand("SELECT * FROM "
			. PostCode::tableName() . 'pc INNER JOIN '
			. Place::tableName() . 'pl ON pl.id=pc.places_id'
			. " WHERE pc.postcode = :postcode")
			->bindValue(':postcode', $postcode)
			->queryAll();
		return $models;
	}

	public function actionFindPlace(string $place, string $country_code)
	{
		\Yii::$app->response->format = Response::FORMAT_JSON;
		$models = PostCode::getDb()->createCommand("SELECT * FROM "
			. PostCode::tableName() . 'pc INNER JOIN '
			. Place::tableName() . 'pl ON pl.id=pc.places_id'
			. " WHERE pl.place LIKE :place")
			->bindValue(':place', $place)
			->queryAll();
		return $models;
	}

/*<<<<<CLASS_END*/
} // class SiteController
/*>>>>>CLASS_END*/
