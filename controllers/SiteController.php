<?php
/*<<<<<USES*/
/*Template:Yii2App/controllers/SiteController.php*/
namespace santilin\wrepos\controllers;

use Yii;
use yii\base\ViewNotFoundException;
use yii\web\Controller;
use yii\web\Response;
/*>>>>>USES*/
/*<<<<<DATECONTROL_MAIN*/
use DateTimeZone;
use kartik\datecontrol\DateControl;
/*>>>>>DATECONTROL_MAIN*/
/*<<<<<MAIN*/
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
/*>>>>>MAIN*/
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
/*<<<<<DATECONTROL_ACTIONCONVERT*/
    /**
     * Convert display date for saving to model.
     * Customized to allow datetimes without the time part
     *
     * @return array JSON encoded HTML output
     */
    public function actionConvertDate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $req = Yii::$app->request;
        $post = $req->post();
        if (!isset($post['displayDate'])) {
            return ['status' => 'error', 'output' => 'No display date found'];
        }
        $saveFormat = $req->post('saveFormat', '');
        $saveTimezone = $req->post('saveTimezone', '');
        $dispFormat = $req->post('dispFormat', '');
        $dispTimezone = $req->post('dispTimezone', '');
        $displayDate = trim($req->post('displayDate', ''));
        $settings = $req->post('settings', []);
        $type = $req->post('type');
        $date = DateControl::getTimestamp($displayDate, $dispFormat, $dispTimezone, $settings);
        if (empty($date) || !$date) {
			if ($type == DateControl::FORMAT_DATETIME) {
				$onlyDateFormat = Yii::$app->getModule('datecontrol')->getDisplayFormat(DateControl::FORMAT_DATE);
				// Try to parse only date
				$date = DateControl::getTimestamp($displayDate, $onlyDateFormat, null, $settings);
				$displayDate = $date->setTime(12,0,0)->format($dispFormat); // compat wit datetimevalidator
				$date = DateControl::getTimestamp($displayDate, $dispFormat, $dispTimezone, $settings);
			}
		}
        if (empty($date) || !$date) {
            $value = '';
        } elseif ($saveTimezone != null) {
            $value = $date->setTimezone(new DateTimeZone($saveTimezone))->format($saveFormat);
        } else {
            $value = $date->format($saveFormat);
        }
        return ['status' => 'success', 'output' => $value];
    }
/*>>>>>DATECONTROL_ACTIONCONVERT*/
/*<<<<<CLASS_END*/
} // class SiteController
/*>>>>>CLASS_END*/
