<?php
namespace santilin\churros;

use Yii;

class Module extends \yii\base\Module
{
	public $controllerNamespace = 'wrepos\controllers';

	public function init()
	{
		parent::init();
		if (Yii::$app instanceof \yii\console\Application) {
			$this->controllerNamespace = 'wrepos\console\controllers';
		}

	}

} // class Module
