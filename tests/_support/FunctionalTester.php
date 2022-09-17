<?php
/*<<<<<MAIN*/
/**
 * @class FunctionalTester
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
*/
class FunctionalTester extends \Codeception\Actor
{
    use _generated\FunctionalTesterActions;

   /**
    * Define custom actions here
    */
/*>>>>>MAIN*/
/*<<<<<CUSTOM*/
	public function saveRecord($model, $msg = null) {
		return $this->getScenario()->runStep(new \Codeception\Step\Action('saveRecord', func_get_args()));
	}

	public function readRecord($model, $msg = null) {
		return $this->getScenario()->runStep(new \Codeception\Step\Action('readRecord', func_get_args()));
	}
	public function cantSaveRecord($model, $msg = null) {
		return $this->getScenario()->runStep(new \Codeception\Step\Action('cantSaveRecord', func_get_args()));
	}

	public function cantReadRecord($model, $msg = null) {
		return $this->getScenario()->runStep(new \Codeception\Step\Action('cantReadRecord', func_get_args()));
	}
/*>>>>>CUSTOM*/
/*<<<<<END*/
} // class FunctionalTester
/*>>>>>END*/
