<?php
namespace santilin\wrepos;

use Yii;

class Module extends \yii\base\Module
{
	public $db;
	public $controllerNamespace = 'santilin\wrepos\controllers';

	public function init()
	{
		parent::init();
		$db_config = require(Yii::getAlias('@wrepos/config/db.php'));
		unset ($db_config['class']);
		$db_config['dsn'] = str_replace('@app','@wrepos', $db_config['dsn']);
		$this->db = new yii\db\Connection( $db_config );
		if (Yii::$app instanceof \yii\console\Application) {
			$this->controllerNamespace = 'santilin\wrepos\console\controllers';
		}
	}

} // class Module
