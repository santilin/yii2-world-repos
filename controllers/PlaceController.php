<?php
/*<<<<<USES*/
/*Template:Yii2App/controllers/EmptyController.php*/
namespace santilin\wrepos\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
/*>>>>>USES*/

use santilin\wrepos\models\Place;

/*<<<<<CLASS*/
/**
 * PlaceController an empty controller.
 */
class PlaceController extends base\_BaseEmptyController
{
	/**
	 * @var $layout The layout for this controller
	 */
	public $layout = 'site';
/*>>>>>CLASS*/

	public function behaviors()
	{
		$cors = [
			'Origin' => ['*'],
			'Access-Control-Request-Method' => ['GET'],
			'Access-Control-Allow-Credentials' => null,
			'Access-Control-Max-Age' => 86400,
			'Access-Control-Expose-Headers' => [],
		];

		// Solo en entorno no dev forzamos ese header
		if (!YII_ENV_DEV) {
			$cors['Access-Control-Request-Headers'] = ['strict-origin-when-cross-origin'];
		} else {
			$cors['Access-Control-Request-Headers'] = ['*'];
		}

		return array_merge(parent::behaviors(), [
			'corsFilter' => [
				'class' => \yii\filters\Cors::class,
				'cors'  => $cors,
			],
		]);
	}

	public function actionFindById(int $id)
	{
		\Yii::$app->response->format = Response::FORMAT_JSON;
		$model = Place::findOne($id);
		return $model->getAttributes();
	}

	public function actionFindIdByLevel(int $id, int $level)
	{
		\Yii::$app->response->format = Response::FORMAT_JSON;
		$model = Place::findOne($id);
		while ($model->level > $level) {
			$model = $model->findSupPlaceById($model->id);
		}
		return $model->getAttributes();
	}

	public function actionFindIdByLevelWithSup(int $id, int $level)
	{
		\Yii::$app->response->format = Response::FORMAT_JSON;
		$model = Place::findOne($id);
		while ($model->level > $level) {
			$model = $model->findSupPlaceById($model->id);
		}
		$result = $model->getAttributes();
		$parent = $model->findSupPlaceById($model->id);
		$result['sup_place'] = $parent->getAttributes();
		return $result;
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

	public function actionMunicipioPorIdIne(string $mun_id)
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
		$entidades = $db->createCommand("SELECT * FROM entidades_es WHERE CODIGOINE LIKE :mun_id ORDER BY NOMBRE", ['mun_id' => "$mun_id%"])->queryAll();
		return $entidades;
	}

	public function actionDegurbaEntidadesMenoresPorCodigoIne(string $codigo_ine)
	{
		\Yii::$app->response->format = Response::FORMAT_JSON;
		$p = new Place; // to get the db object
		$db = $p->getDb();
		$entidades = $db->createCommand("SELECT * FROM entidades_es WHERE TIPO IN ('Municipio', 'Entidad singular', 'Entidad colectiva', 'Capital de municipio') AND CODIGOINE LIKE :mun_id ORDER BY NOMBRE", ['mun_id' => "$codigo_ine%"])->queryAll();
		return $entidades;
	}

	public function actionDegurbaEntidadMenorPorCodigoIne(string $codigo_ine)
	{
		\Yii::$app->response->format = Response::FORMAT_JSON;
		$p = new Place; // to get the db object
		$db = $p->getDb();
		$entidades = $db->createCommand("SELECT * FROM entidades_es WHERE TIPO IN ('Municipio', 'Entidad singular', 'Entidad colectiva', 'Capital de municipio') AND CODIGOINE LIKE :mun_id ORDER BY NOMBRE", ['mun_id' => "$codigo_ine%"])->queryAll();
		return $entidades;
	}

	public function actionDegurbaMuncipioPorCodigoIne(string $codigo_ine)
	{
		\Yii::$app->response->format = Response::FORMAT_JSON;
		$p = new Place; // to get the db object
		$db = $p->getDb();
		$entidades = $db->createCommand("SELECT * FROM entidades_es WHERE TIPO IN ('Municipio') AND CODIGOINE LIKE :mun_id ORDER BY NOMBRE", ['mun_id' => "$codigo_ine%"])->queryAll();
		return $entidades;
	}


/*<<<<<CLASS_END*/
} // class PlaceController
/*>>>>>CLASS_END*/
