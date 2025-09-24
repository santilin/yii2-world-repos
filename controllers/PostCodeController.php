<?php
/*<<<<<USES*/
/*Template:Yii2App/controllers/EmptyController.php*/
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\PostCode;
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
	public $layout = 'site';
/*>>>>>CLASS*/

	public function behaviors()
	{
		return array_merge(parent::behaviors(), [
			'corsFilter' => [
				'class' => \yii\filters\Cors::class,
				'cors' => [
					'Origin' => ['*'],
					'Access-Control-Request-Headers' => ['strict-origin-when-cross-origin'],
					'Access-Control-Request-Method' => ['GET'],
					'Access-Control-Allow-Credentials' => null,
					'Access-Control-Max-Age' => 86400,
					'Access-Control-Expose-Headers' => [],
				],
			],
		]);
	}

	public function actionFindTypeAhead(string $search, int $page = 1, int $per_page = 10)
	{
		\Yii::$app->response->format = Response::FORMAT_JSON;
		return PostCode::searchPostCodes($search, $page, $per_page);
	}

	// Cant use Query because postcode has no id
	public function actionFindPostCode(string $postcode, int $country_code = 724)
	{
		\Yii::$app->response->format = Response::FORMAT_JSON;
// 		$models = PostCode::getDb()->createCommand("SELECT * FROM "
// 			. PostCode::tableName() . 'pc INNER JOIN '
// 			. Place::tableName() . 'pl ON pl.id=pc.places_id'
// 			. " WHERE pc.postcode = :postcode")
// 			->bindValue(':postcode', $postcode)
// 			->queryAll();
// 		return $models;
		$postcode_tbl = PostCode::tableName();
		$place_tbl = Place::tableName();
		$sql = <<<SQL
SELECT pc.postcode, plpr.name as provincia, pl.name, '' as poblacion, substr(pc.postcode,1,2) as nuts3_code, pl.level
FROM $postcode_tbl pc
	INNER JOIN $place_tbl pl ON pl.id=pc.places_id
	LEFT JOIN $place_tbl plpr ON pl.admin_sup_code=plpr.admin_code AND plpr.level = 3
WHERE pc.postcode LIKE :postcode_like AND pl.level = 4 /* :place_like */
UNION
SELECT pc.postcode, plpr.name, plmun.name, plentidad.name, substr(pc.postcode,1,2), plentidad.level
FROM $postcode_tbl pc
	INNER JOIN $place_tbl pl ON pl.id=pc.places_id
	INNER JOIN $place_tbl plentidad ON plentidad.admin_sup_code=pl.admin_code AND plentidad.level >= 5
	LEFT JOIN $place_tbl plmun ON plentidad.admin_sup_code=plmun.admin_code AND plmun.level = 4
	LEFT JOIN $place_tbl plpr ON plmun.admin_sup_code=plpr.admin_code AND plpr.level = 3
WHERE pc.postcode LIKE :postcode_like
SQL;
		$models = PostCode::getDb()->createCommand($sql)
			->bindValue(':postcode_like', $postcode . '%')
			->queryAll();
		return $models;
	}

	public function actionFindPlace(string $place, int $country_code = 724)
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
