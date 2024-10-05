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
		if (Yii::$app instanceof \yii\console\Application) {
			$this->controllerNamespace = 'santilin\wrepos\console\controllers';
			$db_config = require(Yii::getAlias('@wrepos/config/console.php'));
		} else {
			$db_config = require(Yii::getAlias('@wrepos/config/web.php'));
		}
		// Set this module db connection when used from another app
		unset($db_config['components']['db']['class']);
		$db_config['components']['db']['dsn'] = str_replace('@app','@wrepos', $db_config['components']['db']['dsn']);
		$this->db = new yii\db\Connection( $db_config['components']['db'] );
	}

} // class Module
