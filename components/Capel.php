<?php
/*<<<<<USES*/
namespace app\components;
use yii;
use \santilin\churros\helpers\AppHelper;
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

];
	const MODULES = [

];
/*>>>>>MODELS*/
/*<<<<<HELPERS*/
	static public function getModels()
	{
		return self::MODELS;
	}

	static public function getModules()
	{
		return self::MODULES;
	}
	static public function modulesWithAccess()
	{
		$user_component = Yii::$app->get('user');
		$ret = [];
		foreach( static::getModules() as $mk => $mtitle ) {
			if( !$user_component || AppHelper::userIsAdmin() || $user_component->can($mk) ) {
				$ret[$mk] = $mtitle;
			}
		}
		return $ret;
	}
	static public function moduleTitle($module_id = null )
	{
		if( $module_id == null ) {
			$module_id = Yii::$app->controller->module->id;
		}
		if( $module_id ) {
			return strtolower(static::getModules()[$module_id]);
		} else {
			return '';
		}
	}
/*>>>>>HELPERS*/
/*<<<<<END*/
} // end class
/*>>>>>END*/
