<?php
/*<<<<<MAIN*/
namespace santilin\wrepos\controllers;

use Yii;
use yii\base\ViewNotFoundException;
use yii\web\Controller;
use yii\web\Response;
/*>>>>>MAIN*/
/*<<<<<USES*/
class SiteController extends Controller
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
/*<<<<<ACTIONS_BEGIN*/
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        $actions = [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
/*>>>>>ACTIONS_BEGIN*/
/*<<<<<ACTIONS*/
		return $actions;
    } // actions()
/*>>>>>ACTIONS*/
/*<<<<<ERROR*/
    /**
     * Displays error page (customized for server codes: 4xx, 5xx) if view present en views/site.
     *
     * @return string
     */
	public function actionError()
	{
		$exception = Yii::$app->errorHandler->exception;
		if ($exception !== null) {
			$error = $exception->statusCode;
			try {
				return $this->render( "error$error", [ 'name' => $error, 'message' => $exception->getMessage(), 'exception' => $exception] );
			} catch(ViewNotFoundException $e) {
				return $this->render( "error", [ 'name' => $error, 'message' => $exception->getMessage(), 'exception' => $exception] );
			}
		}
	}
/*>>>>>ERROR*/
/*<<<<<INDEX*/
	/**
	 * Displays index page.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		$params = [];
/*>>>>>INDEX*/
/*<<<<<INDEX_END*/
		return $this->render('index', $params);
	}
/*>>>>>INDEX_END*/
/*<<<<<CLASS_END*/
} // class SiteController
/*>>>>>CLASS_END*/
