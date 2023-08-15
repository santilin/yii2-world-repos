<?php

namespace santilin\wrepos\models;
use \yii\db\ActiveRecord;


class _BaseModel extends ActiveRecord
{
	// Overloaded to use this module db (created in Module::Init()
	public static function getDb()
	{
		return \Yii::$app->controller->module->db;
	}
}
