<?php
namespace santilin\wrepos;

use Yii;

class Module extends \yii\base\Module
{
	public $controllerNamespace = 'santilin\wrepos\controllers';

	public function init()
	{
		parent::init();
		if (Yii::$app instanceof \yii\console\Application) {
			$this->controllerNamespace = 'santilin\wrepos\console\controllers';
		}
	}

} // class Module
