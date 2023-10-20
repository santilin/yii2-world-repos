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

	public function actionFindTypeAhead(string $search, int $page = 1, int $per_page = 10)
	{
		$search = trim($search);
		$postcode_tbl = PostCode::tableName();
		$place_tbl = Place::tableName();
		$sql = '';
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
			}
		} else {
				$sql = <<<SQL
SELECT pc.postcode, plpr.name as nuts3, pl.name as nuts4, '' as nuts5, substr(pc.postcode,1,2) as nuts3_code
FROM $postcode_tbl pc
	INNER JOIN $place_tbl pl ON pl.id=pc.places_id
	LEFT JOIN $place_tbl plpr ON pl.admin_sup_code=plpr.admin_code AND plpr.level = 3
WHERE (pc.postcode LIKE :postcode_like OR pl.name LIKE :place_like) AND pl.level = 4
UNION
SELECT pc.postcode, plpr.name, plmun.name, pl.name, substr(pc.postcode,1,2)
FROM $postcode_tbl pc
	INNER JOIN $place_tbl pl ON pl.id=pc.places_id
	LEFT JOIN $place_tbl plmun ON pl.admin_sup_code=plmun.admin_code AND plmun.level = 4
	LEFT JOIN $place_tbl plpr ON plmun.admin_sup_code=plpr.admin_code AND plpr.level = 3
WHERE (pc.postcode LIKE :postcode_like OR pl.name LIKE :place_like) AND pl.level IN (5,6)
UNION
SELECT GROUP_CONCAT(pc.postcode), plpr.name, plmun.name, pl.name, substr(pc.postcode,1,2)
FROM $place_tbl pl
	INNER JOIN $place_tbl plmun ON pl.admin_sup_code=plmun.admin_code AND plmun.level = 4
		LEFT JOIN $postcode_tbl pc ON plmun.id=pc.places_id
	INNER JOIN $place_tbl plpr ON plmun.admin_sup_code=plpr.admin_code AND plpr.level = 3
WHERE (pc.postcode LIKE :postcode_like OR pl.name LIKE :place_like) AND pl.level >= 5
GROUP BY 2,3,4,5
HAVING COUNT(pc.postcode)=1
UNION
SELECT '', plpr.name, plmun.name, pl.name, substr(pc.postcode,1,2)
FROM $place_tbl pl
	INNER JOIN $place_tbl plmun ON pl.admin_sup_code=plmun.admin_code AND plmun.level = 4
		LEFT JOIN $postcode_tbl pc ON plmun.id=pc.places_id
	INNER JOIN $place_tbl plpr ON plmun.admin_sup_code=plpr.admin_code AND plpr.level = 3
WHERE (pc.postcode LIKE :postcode_like OR pl.name LIKE :place_like) AND pl.level >= 5
GROUP BY 2,3,4,5
HAVING COUNT(pc.postcode)>1
SQL;

	}
		if (!empty($sql)) {
			if ($per_page != 0) {
				if ($page == 0 ) {
					$page = 1;
				}
				$sql .= ' LIMIT ' . ($page-1) * $per_page . ",$per_page";
			}
			$models = PostCode::getDb()->createCommand($sql)
				->bindValue(':postcode_like', $search . '%')
				->bindValue(':place_like', "%$search%")
				->queryAll();
		} else {
			$models = [];
		}
		\Yii::$app->response->format = Response::FORMAT_JSON;
		return $models;
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
