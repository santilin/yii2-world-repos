<?php
/*<<<<<INIT*/
namespace app\components;
use yii;
/**
 * Meta information for the app world-repositories
 * @version 0.0.1
 */
/*>>>>>INIT*/
/*<<<<<CLASS*/
class Capel
{
/*>>>>>CLASS*/
/*<<<<<MODELS*/
	const MODELS = [
'Country' => [
	'class' => 'app\models\Country',
	'type' => 'models',
	'fields' => [
		"id" => [ "name" => "id", "type" => "tinyInteger",
			"length" => null,"precision" => null,"title" => "Id","title_plural" => "Ides","required" => true,"app_type" => "key/primary/tiny","values_callback" => ""],
		"iso2" => [ "name" => "iso2", "type" => "string",
			"length" => 2,"precision" => null,"title" => "Iso2","title_plural" => "Iso2s","required" => true,"app_type" => "string","values_callback" => ""],
		"iso3" => [ "name" => "iso3", "type" => "string",
			"length" => 2,"precision" => null,"title" => "Iso3","title_plural" => "Iso3s","required" => true,"app_type" => "string","values_callback" => ""],
		"name" => [ "name" => "name", "type" => "string",
			"length" => null,"precision" => null,"title" => "Name","title_plural" => "Names","required" => false,"app_type" => "places/country/name","values_callback" => ""],
	],
],

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
		$user_module = Yii::$app->user;
		$ret = [];
		foreach( static::getModules() as $mk => $mtitle ) {
			if( !$user_module || $user_module->can($mk) ) {
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
