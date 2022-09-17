<?php
/*<<<<<MAIN*/
namespace Helper;
// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Functional extends \Codeception\Module
{
	public function _before(\Codeception\TestInterface $test)
	{
		// Fixes the generating of assets files in @app/assets
		\Yii::setAlias('@webroot', '@app/web');
		\Yii::setAlias('@web', '/');
	}
/*>>>>>MAIN*/
/*<<<<<END*/
} // class Functional
/*>>>>>END*/
