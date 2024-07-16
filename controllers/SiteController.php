<?php
/*<<<<<USES*/
/*Template:Yii2App/controllers/SiteController.php*/
namespace santilin\wrepos\controllers;

use Yii;
use yii\base\ViewNotFoundException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
/*>>>>>USES*/
/*<<<<<MAIN*/
class SiteController extends Controller
{
	/**
	 * @var $layout The layout for this controller
	 */
	public $layout = 'site';
	/**
	 * @inheritdoc
	 */
    public $enableCsrfValidation = false;
/*>>>>>MAIN*/
/*<<<<<BEHAVIORS*/
    public function behaviors()
    {
		$b = parent::behaviors();
/*>>>>>BEHAVIORS*/
/*<<<<<BEHAVIORS_END*/
		return $b;
	}
/*>>>>>BEHAVIORS_END*/
/*<<<<<MAINTENANCE_BEGIN_PAGE*/
	/**

	 * Displays the maintenance page.
	 *
	 * @return string
	 */
	public function actionMaintenance($message)
	{
		$params = [ 'message' => $message ];
		$this->layout = 'login';
		if (isset($_GET['tag'])) { // debug module
			die;
		}
/*>>>>>MAINTENANCE_BEGIN_PAGE*/
/*<<<<<MAINTENANCE_END_PAGE*/
		return $this->render('maintenance', $params);
	}
/*>>>>>MAINTENANCE_END_PAGE*/
/*<<<<<ERROR*/
    /**
     * Displays error page (customized for server codes: 4xx, 5xx) if view present in views/site.
     *
     * @return string
     */
	public function actionError()
	{
		$exception = Yii::$app->errorHandler->exception;
		if ($exception !== null) {
			if( $exception instanceof \yii\web\HttpException) {
				$error = $exception->statusCode;
				try {
					return $this->render( "error$error", [ 'name' => 'Error', 'message' => $exception->getMessage(), 'exception' => $exception] );
				} catch(ViewNotFoundException $e) {
					return $this->render( "error", [ 'name' => 'Error', 'message' => $exception->getMessage(), 'exception' => $exception] );
				}
			} else {
				return $this->render( "error", [ 'name' => 'Error', 'message' => $exception->getMessage(), 'exception' => $exception] );
			}
		}
	}
/*>>>>>ERROR*/
/*<<<<<INDEX_BEGIN_PAGE*/
	/**

	 * Displays index page.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		$params = [];
/*>>>>>INDEX_BEGIN_PAGE*/
/*<<<<<INDEX_END_PAGE*/
		return $this->render('index', $params);
	}
/*>>>>>INDEX_END_PAGE*/
/*<<<<<CLASS_END*/
} // class SiteController
/*>>>>>CLASS_END*/
