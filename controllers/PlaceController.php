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

	public function actionFindPlace(string $place, string $country_code)
	{
		\Yii::$app->response->format = Response::FORMAT_JSON;
		$models = Place::find()->where(['LIKE', 'name', $place])->asArray()->all();
		return $models;
	}

	public function actionIdIne(string $nombre)
	{
		\Yii::$app->response->format = Response::FORMAT_JSON;
		$p = new Place; // to get the db object
		$db = $p->getDb();
		return $db->createCommand("SELECT * FROM entidades_es WHERE NOMBRE = :nombre AND TIPO = 'Municipio'", ['nombre' => $nombre])->queryOne();
	}

	public function actionDegurbaMunicipioPorIdIne(string $mun_id)
	{
		\Yii::$app->response->format = Response::FORMAT_JSON;
		$p = new Place; // to get the db object
		$db = $p->getDb();
		return $db->createCommand("SELECT * FROM entidades_es WHERE INEMUNI = :mun_id", ['mun_id' => $mun_id])->queryOne();
	}

	public function actionDegurbaEntidadesPorIdIne(string $mun_id)
	{
		\Yii::$app->response->format = Response::FORMAT_JSON;
		$p = new Place; // to get the db object
		$db = $p->getDb();
		$municipio = $db->createCommand("SELECT * FROM entidades_es WHERE INEMUNI LIKE :mun_id", ['mun_id' => "$mun_id%"])->queryAll();
		return $municipio;
	}

	public function actionDegurbaEntidadesMenoresPorIdIne(string $mun_id)
	{
		\Yii::$app->response->format = Response::FORMAT_JSON;
		$p = new Place; // to get the db object
		$db = $p->getDb();
		$municipio = $db->createCommand("SELECT * FROM entidades_es WHERE TIPO IN ('Municipio', 'Entidad singular', 'Entidad colectiva', 'Capital de municipio') AND INEMUNI LIKE :mun_id", ['mun_id' => "$mun_id%"])->queryAll();
		return $municipio;
	}



/*<<<<<CLASS_END*/
} // class SiteController
/*>>>>>CLASS_END*/
