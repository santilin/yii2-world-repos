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
 * world-repos Places console commands
 *
 * @author Santilín
 * @since 1.0
 */
class PlacesController extends Controller
{
	/** The version of this command */
	public const VERSION = '0.0.1';
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
	public function actionImportCountries(string $table, array $fields, string $language = 'ES')
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
	public function actionImportPlaces(string $dest_model_name, array $fields, ?string $conds = null, string $country = 'ES')
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
		$model->provincias_esp_id = intval(substr($place->admin_code,0,2));
	}

	const PROVINCIAS_COMUNIDADES = [
		'ES111' => 12, // Galicia
		'ES112' => 12, // Galicia
		'ES113' => 12, // Galicia
		'ES114' => 12, // Galicia
		'ES120' => 3,  // Principado de Asturias
		'ES130' => 6,  // Cantabria
		'ES211' => 17, // Pais Vasco
		'ES212' => 17, // Pais Vasco
		'ES213' => 17, // Pais Vasco
		'ES220' => 16, // Comunidad Foral de Navarra
		'ES230' => 13, // La Rioja
		'ES241' => 2,  // Aragon
		'ES242' => 2,  // Aragon
		'ES243' => 2,  // Aragon
		'ES300' => 14, // Comunidad de Madrid
		'ES411' => 8,  // Castilla y Leon
		'ES412' => 8,  // Castilla y Leon
		'ES413' => 8,  // Castilla y Leon
		'ES414' => 8,  // Castilla y Leon
		'ES415' => 8,  // Castilla y Leon
		'ES416' => 8,  // Castilla y Leon
		'ES417' => 8,  // Castilla y Leon
		'ES418' => 8,  // Castilla y Leon
		'ES419' => 8,  // Castilla y Leon
		'ES421' => 7,  // Castilla La Mancha
		'ES422' => 7,  // Castilla La Mancha
		'ES423' => 7,  // Castilla La Mancha
		'ES424' => 7,  // Castilla La Mancha
		'ES425' => 7,  // Castilla La Mancha
		'ES431' => 11, // Extremadura
		'ES432' => 11, // Extremadura
		'ES511' => 9,  // Cataluña
		'ES512' => 9,  // Cataluña
		'ES513' => 9,  // Cataluña
		'ES514' => 9,  // Cataluña
		'ES521' => 10, // Comunidad Valenciana
		'ES522' => 10, // Comunidad Valenciana
		'ES523' => 10, // Comunidad Valenciana
		'ES611' => 1,  // Andalucía
		'ES612' => 1,  // Andalucía
		'ES613' => 1,  // Andalucía
		'ES614' => 1,  // Andalucía
		'ES615' => 1,  // Andalucía
		'ES616' => 1,  // Andalucía
		'ES617' => 1,  // Andalucía
		'ES618' => 1,  // Andalucía
		'ES620' => 15, // Región de Murcia
		'ES630' => 18, // Ceuta
		'ES640' => 19, // Melilla
		'ES701' => 5,  // Canarias
		'ES702' => 5,  // Canarias
	];


	public function setComunidadAutonoma($model, $place)
	{
		$model->comunidad_autonoma = self::PROVINCIAS_COMUNIDADES[$place->admin_code];
	}

	public function actionImportaMunicipios(
		string $dest_model_name, array $fields, ?string $conds = null)
	{
		$exitcode = ExitCode::OK;
		if (!str_contains($dest_model_name, "\\")) {
			$dest_model_name = "\\app\\models\\$dest_model_name";
		}
		if ($conds == null) {
			$conds = "level in (4,5)";
		}
		$count = Place::importToModel([$this, 'setProvincia'], $dest_model_name, $fields,
									  $conds, 'ES');
		$this->stdout("Importados $count municipios a $dest_model_name\n");
		return $exitcode;
	}


	public function actionImportaProvincias(
		string $dest_model_name, array $fields, ?string $conds = null)
	{
		$exitcode = ExitCode::OK;
		if (!str_contains($dest_model_name, "\\")) {
			$dest_model_name = "\\app\\models\\$dest_model_name";
		}
		if ($conds == null) {
			$conds = "level=3";
		}
		$count = Place::importToModel([$this, 'setComunidadAutonoma'], $dest_model_name, $fields,
									  $conds, 'ES');
		$this->stdout("Importadas $count provincias a $dest_model_name\n");
		return $exitcode;
	}


/*<<<<<CLASS_END*/
} // class world-reposController
/*>>>>>CLASS_END*/
