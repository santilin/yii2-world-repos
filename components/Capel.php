<?php
/*<<<<<USES*/
namespace app\components;
use Yii;
use app\helpers\UserHelper;
/**
 * Meta information for the app world-repos
 * @version 0.0.1
 */
/*>>>>>USES*/
/*<<<<<CLASS*/
class Capel
{
/*>>>>>CLASS*/
/*<<<<<MODELS*/
	const MODELS = [
		'Country' => [
			'class' => 'santilin\wrepos\models\Country',
			'type' => 'model',
		],
		'Place' => [
			'class' => 'santilin\wrepos\models\Place',
			'type' => 'model',
		],
		'PostCode' => [
			'class' => 'santilin\wrepos\models\PostCode',
			'type' => 'model',
		],
	];
	const MODULES = [

	];
/*>>>>>MODELS*/
/*<<<<<HELPERS*/
	public static function getModels()
	{
		return self::MODELS;
	}

	public static function getModules()
	{
		return self::MODULES;
	}
	public static function modulesWithAccess($user_component)
	{
		$ret = [];
/*>>>>>HELPERS*/
/*<<<<<MODULES_WITH_ACCESS.NO_RBAC*/
		if (!$user_component || UserHelper::userIsAdmin()) {
			foreach (static::getModules() as $mk => $minfo) {
				$mtitle = $minfo['title'];
				$ret[$mk] = $mtitle;
			}
		}
/*>>>>>MODULES_WITH_ACCESS.NO_RBAC*/
/*<<<<<MODULES_WITH_ACCESS.RETURN*/
		return $ret;
	}
	public static function moduleTitle($module_id = null)
	{
		if ($module_id === null) {
			$module_id = Yii::$app->controller->module->id;
		}
		if ($module_id) {
			return strtolower(static::getModules()[$module_id]['title']);
		} else {
			return '';
		}
	}
/*>>>>>MODULES_WITH_ACCESS.RETURN*/
/*<<<<<END*/
} // end class
/*>>>>>END*/
