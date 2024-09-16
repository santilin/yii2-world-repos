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
		$models = [];
		$search = trim($search);
		$postcode_tbl = PostCode::tableName();
		$place_tbl = Place::tableName();
		$sql = '';
		if ($per_page != 0) {
			if ($page == 0 ) {
				$page = 1;
			}
			$sql_limit = ' LIMIT ' . ($page-1) * $per_page . ",$per_page";
		}
		if (is_numeric($search) ) {
			if (strlen($search)>=4) {
				$sql = <<<SQL
SELECT pc.postcode, plpr.name as nuts3, pl.name as nuts4, '' as nuts5, substr(pc.postcode,1,2) as nuts3_code
FROM $postcode_tbl pc
	INNER JOIN $place_tbl pl ON pl.id=pc.places_id
	LEFT JOIN $place_tbl plpr ON pl.admin_sup_code=plpr.admin_code AND plpr.level = 3
WHERE pc.postcode LIKE :postcode_like AND pl.level = 4 /* :place_like */
UNION
SELECT pc.postcode, plpr.name, plmun.name, pl.name, substr(pc.postcode,1,2)
FROM $postcode_tbl pc
	INNER JOIN $place_tbl pl ON pl.id=pc.places_id
	LEFT JOIN $place_tbl plmun ON pl.admin_sup_code=plmun.admin_code AND plmun.level = 4
	LEFT JOIN $place_tbl plpr ON plmun.admin_sup_code=plpr.admin_code AND plpr.level = 3
WHERE pc.postcode LIKE :postcode_like AND pl.level >= 5
SQL;
				$models = PostCode::getDb()->createCommand($sql. $sql_limit)
				->bindValue(':postcode_like', $search . '%')
				->queryAll();
			}
		} else {
				$sql = <<<SQL
SELECT pc.postcode, plpr.name as nuts3, pl.name as nuts4, '' as nuts5, substr(pc.postcode,1,2) as nuts3_code
FROM $postcode_tbl pc
	INNER JOIN $place_tbl pl ON pl.id=pc.places_id
	LEFT JOIN $place_tbl plpr ON pl.admin_sup_code=plpr.admin_code AND plpr.level = 3
WHERE (pl.name LIKE :place_like) AND pl.level = 4
UNION
SELECT GROUP_CONCAT(pc.postcode), plpr.name, plmun.name, pl.name, substr(pc.postcode,1,2)
FROM $place_tbl pl
	INNER JOIN $place_tbl plmun ON pl.admin_sup_code=plmun.admin_code AND plmun.level = 4
		LEFT JOIN $postcode_tbl pc ON plmun.id=pc.places_id
	INNER JOIN $place_tbl plpr ON plmun.admin_sup_code=plpr.admin_code AND plpr.level = 3
WHERE (pl.name LIKE :place_like) AND pl.level = 5
GROUP BY 2,3,4,5
HAVING COUNT(pc.postcode)=1
UNION
SELECT pc.postcode, plpr.name, plmun.name, plent.name, substr(pc.postcode,1,2)
FROM $place_tbl pl
	INNER JOIN $place_tbl plent ON pl.admin_sup_code=plent.admin_code AND plent.level = 5
	INNER JOIN $place_tbl plmun ON plent.admin_sup_code=plmun.admin_code AND plmun.level = 4
		LEFT JOIN $postcode_tbl pc ON plmun.id=pc.places_id
	INNER JOIN $place_tbl plpr ON plmun.admin_sup_code=plpr.admin_code AND plpr.level = 3
WHERE (pl.name LIKE :place_like) AND pl.level > 5
GROUP BY 2,3,4,5
HAVING COUNT(pc.postcode)>1
SQL;
				$models = PostCode::getDb()->createCommand($sql)
					->bindValue(':place_like', "%$search%")
					->queryAll();
		}
		\Yii::$app->response->format = Response::FORMAT_JSON;
		return $models;
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
