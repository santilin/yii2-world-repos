<?php
/*<<<<<USES*/
/*Template:Yii2App/console/controllers/Controller.php*/
namespace santilin\wrepos\console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\ExitCode;
use yii\console\Controller;
/*>>>>>USES*/
/*<<<<<MAIN*/
/**
 * world-repos console commands
 *
 * @author Santilín
 * @since 1.0
 */
class PlacesController extends Controller
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
		$own_options = ['abortOnError','dryRun'];
/*>>>>>OPTIONS*/
/*<<<<<OPTIONS_END*/
        return array_merge(parent::options($actionID), $own_options);
    }
/*>>>>>OPTIONS_END*/
/*<<<<<ACTION_INDEX*/
	/**
	 * Main action
	 */
	public function actionIndex()
	{
/*>>>>>ACTION_INDEX*/
/*<<<<<ACTION_INDEX_END*/
		return ExitCode::OK;
	} // actionIndex
/*>>>>>ACTION_INDEX_END*/
/*<<<<<PRINT_HELP_MESSAGE*/
    /**
     * Show help message.
     */
    private function printHelpMessage()
    {
        $this->stdout($this->getHelpSummary() . "\n");

        $helpCommand = Console::ansiFormat('yii help world-repos', [Console::FG_CYAN]);
        $this->stdout("Use $helpCommand to get usage info.\n");
    }
/*>>>>>PRINT_HELP_MESSAGE*/
/*<<<<<ACTION_IMPORTCOUNTRIES*/
	/**
	 * Importador de países por lenguajes
	 */
	public function actionImportCountries(string $language='ES')
	{
		$exitcode = ExitCode::OK;
/*>>>>>ACTION_IMPORTCOUNTRIES*/
/*<<<<<ACTION_IMPORTCOUNTRIES_END*/
		return $exitcode;
	} // actionImportCountries
/*>>>>>ACTION_IMPORTCOUNTRIES_END*/
/*<<<<<ACTION_IMPORTPLACES*/
	/**
	 * Importador de lugares: provincias, municipios, etc. por países
	 */
	public function actionImportPlaces(string $country='ES')
	{
		$exitcode = ExitCode::OK;
/*>>>>>ACTION_IMPORTPLACES*/
/*<<<<<ACTION_IMPORTPLACES_END*/
		return $exitcode;
	} // actionImportPlaces
/*>>>>>ACTION_IMPORTPLACES_END*/
/*<<<<<CLASS_END*/
} // class world-reposController
/*>>>>>CLASS_END*/
