<?php
/*<<<<<USES*/
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */
namespace app\components;

use app\components\Capel;
/*>>>>>USES*/
/*<<<<<CLASS*/
class ErrorHandler extends \yii\web\ErrorHandler
{
    /**
     * Renders the exception.
     * @param \Throwable $exception the exception to be rendered.
     */
    protected function renderException($exception)
    {
        $script_url = $_SERVER['SCRIPT_URL'] ?? $_SERVER['REDIRECT_URL'] ?? $_SERVER['HTTP_REFERER'] ?? false;
        if ($script_url !== false) {
            if (preg_match('/^\/([^\/]+)/', $script_url, $matches)) {
                if (in_array($matches[1], array_keys(Capel::MODULES), true)) {
                    $this->errorAction = $matches[1] . '/' . $this->errorAction;
                }
			}
		}
		return parent::renderException($exception);
	}

	/**
     * Handles fatal PHP errors.
     */
    public function handleFatalError()
    {
        $error = error_get_last();
        if ($error && $error['type'] === 1) {
            if (substr($error['message'], 0, 22) === 'Allowed memory size of') {
                if (isset($_SESSION['GridPageSize']) && intval($_SESSION['GridPageSize']) === -1) {
                    unset($_SESSION['GridPageSize']);
                }
            }
        }
        return parent::handleFatalError();
    }
/*>>>>>CLASS*/
/*<<<<<CLASS.END*/
}
/*>>>>>CLASS.END*/
