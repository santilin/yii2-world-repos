<?php
/*<<<<<USES*/
/*Template:Yii2App/controllers/EmptyController.php*/
namespace santilin\wrepos\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
/*>>>>>USES*/
use santilin\wrepos\models\{PostCode,Place};

/*<<<<<CLASS*/
/**
 * PostCodeController an empty controller.
 */
class PostCodeController extends base\_BaseEmptyController
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
		// \Yii::$app->response->format = Response::FORMAT_JSON;
$postcode_tbl = PostCode::tableName();
$place_tbl = Place::tableName();

$sql = <<<SQL
WITH RECURSIVE descendants AS (
    -- ANCHOR: Start directly from postcodes (no intermediate CTE)
    SELECT DISTINCT
        pc.postcode,
        pl.name AS nuts4_path,
        substr(pc.postcode,1,2) AS nuts3_code,
        pl.id,
        pl.level,
        pl.admin_code,
        pl.admin_sup_code
    FROM "postcodes" pc
    JOIN "places" pl ON pl.id = pc.places_id
    WHERE pc.postcode LIKE :postcode_like

    UNION ALL

    -- RECURSIVE: Same as before
    SELECT
        d.postcode,
        d.nuts4_path || ' > ' || child.name,
        d.nuts3_code,
        child.id,
        child.level,
        child.admin_code,
        child.admin_sup_code
    FROM "places" child
    JOIN descendants d ON child.admin_sup_code = d.admin_code
)
SELECT
    postcode,
    nuts3_code,
    nuts4_path AS nuts4,
    id AS place_id,
    level
FROM descendants
WHERE level > 4;
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
} // class PostCodeController
/*>>>>>CLASS_END*/
