<?php
/*<<<<<USES*/
namespace app\console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\ExitCode;
use yii\console\Controller;
/*>>>>>USES*/
/*<<<<<MAIN*/
/**
 * world-repos console commands
 *
 * @author Santilín <santi@noviolento.es>
 * @since 1.0
 */
class WorldReposController extends Controller
{
	/** The version of this command */
	const VERSION = '0.0.1';
	public $abortOnError = false;
	public $dryRun = false;
/*>>>>>MAIN*/
/*<<<<<OPTIONS*/
    /**
     * {@inheritdoc}
     */
    public function options($actionID)
    {
		$own_options = [];
		if( $actionID == "generate" ) {
			$own_options = [
		'abortOnError','dryRun',
		];
		}
/*>>>>>OPTIONS*/
/*<<<<<OPTIONS_END*/
        return array_merge(parent::options($actionID), $own_options);
    }
/*>>>>>OPTIONS_END*/
/*<<<<<ACTION*/
	/**
	 * Main action
	 */
	public function actionIndex()
	{
/*>>>>>ACTION*/
/*<<<<<ACTION_END*/
		return ExitCode::OK;
	} // actionIndex
/*>>>>>ACTION_END*/
/*<<<<<PRINT_HELP_MESSAGE*/
    /**
     * Show help message.
     * @param array $fixturesInput
     */
    private function printHelpMessage()
    {
        $this->stdout($this->getHelpSummary() . "\n");

        $helpCommand = Console::ansiFormat('yii help world-repos', [Console::FG_CYAN]);
        $this->stdout("Use $helpCommand to get usage info.\n");
    }
/*>>>>>PRINT_HELP_MESSAGE*/
/*<<<<<CLASS_END*/
} // class world-reposController
/*>>>>>CLASS_END*/
