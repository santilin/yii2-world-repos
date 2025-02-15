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
	public string $wrepos_dbname = "wrepos";
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

		$count = Place::importToModel(null, $dest_model_name, $fields, $conds, $country);
		$this->stdout("Imported $count places to $dest_model_name\n");

/*<<<<<ACTION_IMPORTPLACES_END*/
		return $exitcode;
	} // actionImportPlaces
/*>>>>>ACTION_IMPORTPLACES_END*/



	public function setProvincia($model, $place)
	{
		static $provincias = [
			"01" => 1,
			"02" => 2,
			"03" => 3,
			"04" => 4,
			"33" => 5,
			"05" => 6,
			"06" => 7,
			"07" => 8,
			"08" => 9,
			"09" => 10,
			"10" => 11,
			"11" => 12,
			"39" => 13,
			"12" => 14,
			"51" => 15,
			"13" => 16,
			"14" => 17,
			"16" => 18,
			"17" => 19,
			"18" => 20,
			"19" => 21,
			"20" => 22,
			"21" => 23,
			"22" => 24,
			"23" => 25,
			"15" => 26,
			"26" => 27,
			"35" => 28,
			"24" => 29,
			"25" => 30,
			"27" => 31,
			"28" => 32,
			"29" => 33,
			"52" => 34,
			"30" => 35,
			"31" => 36,
			"32" => 37,
			"34" => 38,
			"36" => 39,
			"37" => 40,
			"38" => 41,
			"40" => 42,
			"41" => 43,
			"42" => 44,
			"43" => 45,
			"44" => 46,
			"45" => 47,
			"46" => 48,
			"47" => 49,
			"48" => 50,
			"49" => 51,
			"50" => 52,
		];
		$model->provincias_esp_id = $provincias[substr($place->admin_code,0,2)];
	}


	public function actionImportaMunicipios(
		string $dest_model_name, array $fields, string $conds=null)
	{
		$exitcode = ExitCode::OK;
		$count = Place::importToModel([$this, 'setProvincia'], $dest_model_name, $fields,
									  "level in (4,5) and admin_sup_code in ('ES611')", 'ES');
		$this->stdout("Importados $count municitios a $dest_model_name\n");
		return $exitcode;
	}


/*<<<<<CLASS_END*/
} // class world-reposController
/*>>>>>CLASS_END*/
