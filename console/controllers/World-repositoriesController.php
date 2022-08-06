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
 * world-repositories console commands
 *
 * @author Santilín <santi@noviolento.es>
 * @since 1.0
 */
class World-repositoriesController extends Controller
{
	/** The version of this command */
	const VERSION = '0.0.1';
/*>>>>>MAIN*/
/*<<<<<OPTIONS*/
    /**
     * {@inheritdoc}
     */
    public function options($actionID)
    {
		$own_options = [];
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
/*<<<<<ACTION_CHECK_CAPEL*/
	public function actionCheckCapel()
	{
		// https://json-schema.org/understanding-json-schema/index.html
		$validator = new \JsonSchema\Validator();
		$data = json_decode(file_get_contents("world-repositories.capel.json"));
		$validator->validate($data, (object) ['$ref' => 'file://' . realpath('../../../capel/share/definitions/program_schema.json')]);
		if ($validator->isValid()) {
			echo "The supplied JSON validates against the schema.\n";
		} else {
			echo "JSON does not validate. Violations:\n";
			foreach ($validator->getErrors() as $error) {
				echo sprintf("[%s] %s\n", $error['property'], $error['message']);
			}
		}
	}
/*>>>>>ACTION_CHECK_CAPEL*/
/*<<<<<PRINT_HELP_MESSAGE*/
    /**
     * Show help message.
     * @param array $fixturesInput
     */
    private function printHelpMessage()
    {
        $this->stdout($this->getHelpSummary() . "\n");

        $helpCommand = Console::ansiFormat('yii help world-repositories', [Console::FG_CYAN]);
        $this->stdout("Use $helpCommand to get usage info.\n");
    }
/*>>>>>PRINT_HELP_MESSAGE*/
/*<<<<<CLASS_END*/
} // class world-repositoriesController
/*>>>>>CLASS_END*/
