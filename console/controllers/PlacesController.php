<?php
/*<<<<<USES*/
/*Template:Yii2App/console/controllers/Controller.php*/
namespace santilin\wrepos\console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\ExitCode;
use yii\console\Controller;
/*>>>>>USES*/

use santilin\churros\helpers\AppHelper;
use santilin\wrepos\models\{Place,Country};

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
	public bool $dryRun = true;
	public bool $abortOnError = true;
	public string $wrepos_dbname = 'wrepos';
/*>>>>>MAIN*/
/*<<<<<OPTIONS*/
    /**
     * {@inheritdoc}
     */
    public function options($actionID)
    {
		$own_options = ['dryRun','abortOnError','wrepos_dbname'];
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
	public function actionImportCountries(string $table, array $fields, string $language='ES')
	{
		$exitcode = ExitCode::OK;
/*>>>>>ACTION_IMPORTCOUNTRIES*/
/*<<<<<ACTION_IMPORTCOUNTRIES_END*/
		return $exitcode;
	} // actionImportCountries
/*>>>>>ACTION_IMPORTCOUNTRIES_END*/



/*<<<<<ACTION_IMPORTPLACES_SQL*/
	/**
	 * Importador de lugares: provincias, municipios, etc. por países
	 */
	public function actionImportPlacesSql(string $dest_model, array $fields, string $conds, string $country='ES')
	{
		$exitcode = ExitCode::OK;
/*>>>>>ACTION_IMPORTPLACES_SQL*/

		$select_fields = [];
		foreach ($fields as $field) {
			list($orig, $dest) = AppHelper::splitString($field, ':');
			if (empty($dest)) {
				$this->stderr( "$field: wrong format. Must be orig_field:dest_field\n");
				exit(1);
			}
			$select_fields[] = "\"$orig\" as \"$dest\"";
		}
		$this->wrepos_dbname = 'main';
		$places_tablename = $this->wrepos_dbname . '.' . Place::tableName();
		$country_tablename = $this->wrepos_dbname . '.' . Country::tableName();
		$s_fields = implode(',',$select_fields);
		$country_id = Country::instance()->getDb()->createCommand("SELECT id FROM $country_tablename WHERE iso2='$country' or iso3='$country' or name='$country'")->queryScalar();
		if (!$country_id) {
			$this->stderr( "$country: country not found\n");
			exit(1);
		}
		$sql_conds = "countries_id=$country_id";
		if (!empty($conds) && $conds != 'null') {
			$sql_conds .= " AND $conds";
		}
		$sql = <<<sql
INSERT INTO $table SELECT $s_fields FROM $places_tablename WHERE $sql_conds
sql;
		$rows = Place::instance()->getDb()->createCommand($sql)->execute();
		$this->stdout($sql);
/*
delete from territorios; insert into territorios SELECT "id" as "id","name" as "nombre",coalesce("admin_sup_code",'')||'-'||coalesce("admin_code",'') as "nuts_code", level as nivel FROM wrepos.`places` WHERE countries_id=724 and nivel <= 4 order by 3
*/

/*<<<<<ACTION_IMPORTPLACES_SQL_END*/
		return $exitcode;
	} // actionImportPlaces
/*>>>>>ACTION_IMPORTPLACES_SQL_END*/


/*<<<<<ACTION_IMPORTPLACES*/
	/**
	 * Importador de lugares: provincias, municipios, etc. por países
	 */
	public function actionImportPlaces(string $dest_model_name, array $fields, string $conds=null, string $country='ES')
	{
		$exitcode = ExitCode::OK;
/*>>>>>ACTION_IMPORTPLACES*/

		$select_fields = [];
		foreach ($fields as $field) {
			list($orig, $dest) = AppHelper::splitString($field, ':');
			if (empty($dest)) {
				$this->stderr( "$field: wrong format. Must be orig_field:dest_field\n");
				exit(1);
			}
			$select_fields[$dest] = $orig;
		}
		$country_id = Country::find()->where(['or', [ 'iso2' => $country, 'iso3' => $country, 'name' => $country]])->scalar();
		if (!$country_id) {
			$this->stderr( "$country: country not found\n");
			exit(1);
		}
		$sql_conds = "countries_id=$country_id";
		if (!empty($conds) && $conds != 'null') {
			$sql_conds .= " AND $conds";
		}
		$places = Place::find()->where($sql_conds)->all();
		foreach ($places as $place) {
			$dest_model = $dest_model_name::findOne($place->id);
			if (!$dest_model) {
				$dest_model = new $dest_model_name;
			}
			foreach ($select_fields as $dest_field => $orig_field) {
				switch ($orig_field) {
					case 'nuts_code':
						$dest_model->$dest_field = implode('-', array_filter([$place->admin_sup_code,$place->admin_code]));
						break;
					default:
						$dest_model->$dest_field = $place->$orig_field;
				}
			}
			if ($dest_model->save()) {
				$this->stdout($dest_model->recordDesc('long') + ": imported");
			} else {
				$this->stdout($dest_model->recordDesc('long') + ": error: " + $dest_model->getOneError());
			}
		}
		$rows = count($places);
		$this->stdout("Imported $rows places to $dest_model_name\n");

/*<<<<<ACTION_IMPORTPLACES_END*/
		return $exitcode;
	} // actionImportPlaces
/*>>>>>ACTION_IMPORTPLACES_END*/


/*<<<<<CLASS_END*/
} // class world-reposController
/*>>>>>CLASS_END*/
