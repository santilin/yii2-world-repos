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
 * @author Santilín <santi@noviolento.es>
 * @since 1.0
 */
class SourceController extends Controller
{
	/** The version of this command */
	const VERSION = '0.0.1';
/*>>>>>MAIN*/
	private function escapeSql($str)
	{
		return str_replace("'", "''", $str);
	}

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

	private function lauToCountry($lau)
	{
		if( isset( self::COUNTRY_XX2ISO[substr($lau,0,2)]) ) {
			return self::COUNTRY_XX2ISO[substr($lau,0,2)];
		} else {
			die($lau);
		}
	}
	private function lauToCode(array $nut_reg)
	{
		$ret = $nut_reg['nuts3_id']; // País hasta provincia
		$ret .= substr($nut_reg['lau_id'],2);
		return $ret;
	}


	public function actionCreateTerritoriosTable()
	{
		Yii::$app->db->createCommand("DROP TABLE IF EXISTS territorios")->queryAll();

		Yii::$app->db->createCommand(<<<sql
CREATE TABLE `territorios` (
	`id` integer PRIMARY KEY AUTOINCREMENT NOT NULL,
	`country_id` integer NOT NULL,
	`name` string,
	'nuts_code' string,
	`nuts3_id` integer,
	`city_name` string,
 	`greater_city` string,
	`city_id` string,
	'lau_id' string,
 	`fua_id` string,
 	`level` integer
);
sql
		)->execute();
// 	`lau_es` string,
// 	`lau_en` string,
// 	`latitude` float,
// 	`longitude` float
// 	`nsi_id` integer,
		echo "Tabla territorios creada";
	}

    /*
		39 Países
		Vacíos: XK, BA, RS, MK, UK,
	*/
/*<<<<<ACTION_IMPORTAR*/
	/**
	 * Generador de modelos y migraciones
	 */
	public function actionImportar($country='ES')
	{
/*>>>>>ACTION_IMPORTAR*/
		$nuts3 = Yii::$app->db->createCommand("DELETE FROM territorios")->queryAll();

		// Source provinces from nuts
		foreach( array_keys(self::COUNTRY_XX2ISO) as $cc ) {
			if( $country && $cc != $country) {
				continue;
			}
			$nuts3 = Yii::$app->db->createCommand("SELECT * FROM nuts3 WHERE NUTS_ID like '$cc%'")->queryAll();
			if( count($nuts3) > 0 ) {
				echo "Found " . count($nuts3) . " provinces for country $cc\n";
			}
			foreach( $nuts3 as $nut ) {
				if( strlen($nut['NUTS_ID']) == 3 ) {
					continue; // north, etc
				}
				$values = [
					'country_id' => $this->lauToCountry($nut['NUTS_ID']),
					'nuts_code' => $nut['NUTS_ID'],
					'name' => $this->escapeSql($nut['NUTS_NAME']),
					'latin_name' => $this->escapeSql($nut['NAME_LATN']),
					'nuts3_id' => $nut['NUTS_ID'],
					'level' => $this->nuts3Level($nut),
				];
				$sql = "INSERT INTO territorios ('id','" . implode("','",array_keys($values)) . "') VALUES (null,'"
					. implode("','", $values). "')";
				Yii::$app->db->createCommand($sql)->execute();
			}
		}

		foreach( array_keys(self::COUNTRY_XX2ISO) as $cc ) {
			if( $country && $cc != $country) {
				continue;
			}
			$nuts = Yii::$app->db->createCommand("SELECT * FROM nuts WHERE nuts3_id like '{$cc}%'")->queryAll();
			if( count($nuts) > 0 ) {
				echo "Found " . count($nuts) . " localities for country $cc\n";
				foreach( $nuts as $nut ) {
					$values = [
						'country_id' => $this->lauToCountry($nut['nuts3_id']),
						'nuts_code' => $this->lauToCode($nut),
						'name' => $this->escapeSql($nut['lau_national']),
						'latin_name' => $this->escapeSql($nut['lau_latin']),
						'nuts3_id' => $nut['nuts3_id'],
						'fua_id' => $nut['fua_id'],
						'lau_id' => $nut['lau_id'],
						'city_id' => $nut['city_id'],
						'greater_city' => $nut['greater_city_id'],
					];
					$sql = "INSERT INTO territorios ('id','" . implode("','",array_keys($values)) . "') VALUES (null,'"
						. implode("','", $values). "')";
					Yii::$app->db->createCommand($sql)->execute();
	// 					echo "Insertando {$values['lau_national']}\n";
				}
			}
		}

/*<<<<<ACTION_IMPORTAR_END*/
		return ExitCode::OK;
	} // actionImportar
/*>>>>>ACTION_IMPORTAR_END*/


	public function actionCodigosPostalesEs()
	{
		$sql_cp = <<<sql
select t.id, p.POSTCODE AS cp,t.name,t.nuts3_id,t.lau_id from territorios t inner join post p on t.nuts3_id=p.nuts3_2021 and t.lau_id=p.nsi_code where t.nuts3_id like 'ES62%' GROUP BY p.CITY_ID,lau_nat,p.POSTCODE
sql;
		$command = Yii::$app->db->createCommand($sql_cp);
		$cps = [];
		$cursor = $command->query();
		while( $row = $cursor->read() ) {
			if (isset($cps[$row['id']])) {
				if (!in_array($row['cp'], $cps[$row['id']])) {
					$cps[$row['id']][] = $row['cp'];
				}
			} else {
				$cps[$row['id']] = [$row['cp']];
			}
		}
		$cursor->close();
		foreach ($cps as $id => $cps_array) {
			$cps = implode(",",$cps_array);
			$sql_update = <<<sql
UPDATE territorios set postcode = '$cps' WHERE id=$id
sql;
			Yii::$app->db->createCommand($sql_update)->execute();
		}
	}

	private function nuts3Level($values)
	{
		$nutsid = $values['NUTS_ID'];
		switch( $nutsid ) {
			case "ES531":
			case "ES532":
			case "ES533":
			case "ES703":
			case "ES704":
			case "ES705":
			case "ES706":
			case "ES707":
			case "ES708":
			case "ES709":
				return 4;
			default:
				if( strlen($nutsid) == 2 ) {
					return 0; // País
				} else if( strlen($nutsid) == 4 ) {
					return 2; // Comunidad autónoma
				} else {
					return 3; // Provincia
				}
			break;
		}
	}

	const COUNTRY_XX2ISO = [
		'ZW' => 716, // ZWE
		'ZM' => 894, // ZMB
		'ZA' => 710, // ZAF
		'YT' => 175, // MYT
		'YE' => 887, // YEM
		'WS' => 882, // WSM
		'WF' => 876, // WLF
		'VU' => 548, // VUT
		'VN' => 704, // VNM
		'VI' => 850, // VIR
		'VG' => 92, // VGB
		'VE' => 862, // VEN
		'VC' => 670, // VCT
		'VA' => 336, // VAT
		'UZ' => 860, // UZB
		'UY' => 858, // URY
		'US' => 840, // USA
		'UM' => 581, // UMI
		'UG' => 800, // UGA
		'UA' => 804, // UKR
		'TZ' => 834, // TZA
		'TW' => 158, // TWN
		'TV' => 798, // TUV
		'TT' => 780, // TTO
		'TR' => 792, // TUR
		'TO' => 776, // TON
		'TN' => 788, // TUN
		'TM' => 795, // TKM
		'TL' => 626, // TLS
		'TK' => 772, // TKL
		'TJ' => 762, // TJK
		'TH' => 764, // THA
		'TG' => 768, // TGO
		'TF' => 260, // ATF
		'TD' => 148, // TCD
		'TC' => 796, // TCA
		'SZ' => 748, // SWZ
		'SY' => 760, // SYR
		'SX' => 534, // SXM
		'SV' => 222, // SLV
		'ST' => 678, // STP
		'SS' => 728, // SSD
		'SR' => 740, // SUR
		'SO' => 706, // SOM
		'SN' => 686, // SEN
		'SM' => 674, // SMR
		'SL' => 694, // SLE
		'SK' => 703, // SVK
		'SJ' => 744, // SJM
		'SI' => 705, // SVN
		'SH' => 654, // SHN
		'SG' => 702, // SGP
		'SE' => 752, // SWE
		'SD' => 729, // SDN
		'SC' => 690, // SYC
		'SB' => 90, // SLB
		'SA' => 682, // SAU
		'RW' => 646, // RWA
		'RU' => 643, // RUS
		'RS' => 688, // SRB
		'RO' => 642, // ROU
		'RE' => 638, // REU
		'QA' => 634, // QAT
		'PY' => 600, // PRY
		'PW' => 585, // PLW
		'PT' => 620, // PRT
		'PS' => 275, // PSE
		'PR' => 630, // PRI
		'PN' => 612, // PCN
		'PM' => 666, // SPM
		'PL' => 616, // POL
		'PK' => 586, // PAK
		'PH' => 608, // PHL
		'PG' => 598, // PNG
		'PF' => 258, // PYF
		'PE' => 604, // PER
		'PA' => 591, // PAN
		'OM' => 512, // OMN
		'NZ' => 554, // NZL
		'NU' => 570, // NIU
		'NR' => 520, // NRU
		'NP' => 524, // NPL
		'NO' => 578, // NOR
		'NL' => 528, // NLD
		'NI' => 558, // NIC
		'NG' => 566, // NGA
		'NF' => 574, // NFK
		'NE' => 562, // NER
		'NC' => 540, // NCL
		'NA' => 516, // NAM
		'MZ' => 508, // MOZ
		'MY' => 458, // MYS
		'MX' => 484, // MEX
		'MW' => 454, // MWI
		'MV' => 462, // MDV
		'MU' => 480, // MUS
		'MT' => 470, // MLT
		'MS' => 500, // MSR
		'MR' => 478, // MRT
		'MQ' => 474, // MTQ
		'MP' => 580, // MNP
		'MO' => 446, // MAC
		'MN' => 496, // MNG
		'MM' => 104, // MMR
		'ML' => 466, // MLI
		'MK' => 807, // MKD
		'MH' => 584, // MHL
		'MG' => 450, // MDG
		'MF' => 663, // MAF
		'ME' => 499, // MNE
		'MD' => 498, // MDA
		'MC' => 492, // MCO
		'MA' => 504, // MAR
		'LY' => 434, // LBY
		'LV' => 428, // LVA
		'LU' => 442, // LUX
		'LT' => 440, // LTU
		'LS' => 426, // LSO
		'LR' => 430, // LBR
		'LK' => 144, // LKA
		'LI' => 438, // LIE
		'LC' => 662, // LCA
		'LB' => 422, // LBN
		'LA' => 418, // LAO
		'KZ' => 398, // KAZ
		'KY' => 136, // CYM
		'KW' => 414, // KWT
		'KR' => 410, // KOR
		'KP' => 408, // PRK
		'KN' => 659, // KNA
		'KM' => 174, // COM
		'KI' => 296, // KIR
		'KH' => 116, // KHM
		'KG' => 417, // KGZ
		'KE' => 404, // KEN
		'JP' => 392, // JPN
		'JO' => 400, // JOR
		'JM' => 388, // JAM
		'JE' => 832, // JEY
		'IT' => 380, // ITA
		'IS' => 352, // ISL
		'IR' => 364, // IRN
		'IQ' => 368, // IRQ
		'IO' => 86, // IOT
		'IN' => 356, // IND
		'IM' => 833, // IMN
		'IL' => 376, // ISR
		'IE' => 372, // IRL
		'ID' => 360, // IDN
		'HU' => 348, // HUN
		'HT' => 332, // HTI
		'HR' => 191, // HRV
		'HN' => 340, // HND
		'HM' => 334, // HMD
		'HK' => 344, // HKG
		'GY' => 328, // GUY
		'GW' => 624, // GNB
		'GU' => 316, // GUM
		'GT' => 320, // GTM
		'GS' => 239, // SGS
		'GR' => 300, // GRC
		'GQ' => 226, // GNQ
		'GP' => 312, // GLP
		'GN' => 324, // GIN
		'GM' => 270, // GMB
		'GL' => 304, // GRL
		'GI' => 292, // GIB
		'GH' => 288, // GHA
		'GG' => 831, // GGY
		'GF' => 254, // GUF
		'GE' => 268, // GEO
		'GD' => 308, // GRD
		'GB' => 826, // GBR
		'GA' => 266, // GAB
		'FR' => 250, // FRA
		'FO' => 234, // FRO
		'FM' => 583, // FSM
		'FK' => 238, // FLK
		'FJ' => 242, // FJI
		'FI' => 246, // FIN
		'ET' => 231, // ETH
		'ES' => 724, // ESP
		'ER' => 232, // ERI
		'EH' => 732, // ESH
		'EG' => 818, // EGY
		'EE' => 233, // EST
		'EC' => 218, // ECU
		'DZ' => 012, // DZA
		'DO' => 214, // DOM
		'DM' => 212, // DMA
		'DK' => 208, // DNK
		'DJ' => 262, // DJI
		'DE' => 276, // DEU
		'CZ' => 203, // CZE
		'CY' => 196, // CYP
		'CX' => 162, // CXR
		'CW' => 531, // CUW
		'CV' => 132, // CPV
		'CU' => 192, // CUB
		'CR' => 188, // CRI
		'CO' => 170, // COL
		'CN' => 156, // CHN
		'CM' => 120, // CMR
		'CL' => 152, // CHL
		'CK' => 184, // COK
		'CI' => 384, // CIV
		'CH' => 756, // CHE
		'CG' => 178, // COG
		'CF' => 140, // CAF
		'CD' => 180, // COD
		'CC' => 166, // CCK
		'CA' => 124, // CAN
		'BZ' => 84, // BLZ
		'BY' => 112, // BLR
		'BW' => 72, // BWA
		'BV' => 74, // BVT
		'BT' => 64, // BTN
		'BS' => 44, // BHS
		'BR' => 76, // BRA
		'BQ' => 535, // BES
		'BO' => 68, // BOL
		'BN' => 96, // BRN
		'BM' => 60, // BMU
		'BL' => 652, // BLM
		'BJ' => 204, // BEN
		'BI' => 108, // BDI
		'BH' => 48, // BHR
		'BG' => 100, // BGR
		'BF' => 854, // BFA
		'BE' => 56, // BEL
		'BD' => 50, // BGD
		'BB' => 52, // BRB
		'BA' => 70, // BIH
		'AZ' => 31, // AZE
		'AX' => 248, // ALA
		'AW' => 533, // ABW
		'AU' => 36, // AUS
		'AT' => 40, // AUT
		'AS' => 16, // ASM
		'AR' => 32, // ARG
		'AQ' => 10, // ATA
		'AO' => 24, // AGO
		'AM' => 51, // ARM
		'AL' => 8, // ALB
		'AI' => 660, // AIA
		'AG' => 28, // ATG
		'AF' => 4, // AFG
		'AE' => 784, // ARE
		'AD' => 20, // AND
	];

	const COUNTRY_ISO2XX = [
		716 => 'ZW', // ZWE
		894 => 'ZM', // ZMB
		710 => 'ZA', // ZAF
		175 => 'YT', // MYT
		887 => 'YE', // YEM
		882 => 'WS', // WSM
		876 => 'WF', // WLF
		548 => 'VU', // VUT
		704 => 'VN', // VNM
		850 => 'VI', // VIR
		92 => 'VG', // VGB
		862 => 'VE', // VEN
		670 => 'VC', // VCT
		336 => 'VA', // VAT
		860 => 'UZ', // UZB
		858 => 'UY', // URY
		840 => 'US', // USA
		581 => 'UM', // UMI
		800 => 'UG', // UGA
		804 => 'UA', // UKR
		834 => 'TZ', // TZA
		158 => 'TW', // TWN
		798 => 'TV', // TUV
		780 => 'TT', // TTO
		792 => 'TR', // TUR
		776 => 'TO', // TON
		788 => 'TN', // TUN
		795 => 'TM', // TKM
		626 => 'TL', // TLS
		772 => 'TK', // TKL
		762 => 'TJ', // TJK
		764 => 'TH', // THA
		768 => 'TG', // TGO
		260 => 'TF', // ATF
		148 => 'TD', // TCD
		796 => 'TC', // TCA
		748 => 'SZ', // SWZ
		760 => 'SY', // SYR
		534 => 'SX', // SXM
		222 => 'SV', // SLV
		678 => 'ST', // STP
		728 => 'SS', // SSD
		740 => 'SR', // SUR
		706 => 'SO', // SOM
		686 => 'SN', // SEN
		674 => 'SM', // SMR
		694 => 'SL', // SLE
		703 => 'SK', // SVK
		744 => 'SJ', // SJM
		705 => 'SI', // SVN
		654 => 'SH', // SHN
		702 => 'SG', // SGP
		752 => 'SE', // SWE
		729 => 'SD', // SDN
		690 => 'SC', // SYC
		90 => 'SB', // SLB
		682 => 'SA', // SAU
		646 => 'RW', // RWA
		643 => 'RU', // RUS
		688 => 'RS', // SRB
		642 => 'RO', // ROU
		638 => 'RE', // REU
		634 => 'QA', // QAT
		600 => 'PY', // PRY
		585 => 'PW', // PLW
		620 => 'PT', // PRT
		275 => 'PS', // PSE
		630 => 'PR', // PRI
		612 => 'PN', // PCN
		666 => 'PM', // SPM
		616 => 'PL', // POL
		586 => 'PK', // PAK
		608 => 'PH', // PHL
		598 => 'PG', // PNG
		258 => 'PF', // PYF
		604 => 'PE', // PER
		591 => 'PA', // PAN
		512 => 'OM', // OMN
		554 => 'NZ', // NZL
		570 => 'NU', // NIU
		520 => 'NR', // NRU
		524 => 'NP', // NPL
		578 => 'NO', // NOR
		528 => 'NL', // NLD
		558 => 'NI', // NIC
		566 => 'NG', // NGA
		574 => 'NF', // NFK
		562 => 'NE', // NER
		540 => 'NC', // NCL
		516 => 'NA', // NAM
		508 => 'MZ', // MOZ
		458 => 'MY', // MYS
		484 => 'MX', // MEX
		454 => 'MW', // MWI
		462 => 'MV', // MDV
		480 => 'MU', // MUS
		470 => 'MT', // MLT
		500 => 'MS', // MSR
		478 => 'MR', // MRT
		474 => 'MQ', // MTQ
		580 => 'MP', // MNP
		446 => 'MO', // MAC
		496 => 'MN', // MNG
		104 => 'MM', // MMR
		466 => 'ML', // MLI
		807 => 'MK', // MKD
		584 => 'MH', // MHL
		450 => 'MG', // MDG
		663 => 'MF', // MAF
		499 => 'ME', // MNE
		498 => 'MD', // MDA
		492 => 'MC', // MCO
		504 => 'MA', // MAR
		434 => 'LY', // LBY
		428 => 'LV', // LVA
		442 => 'LU', // LUX
		440 => 'LT', // LTU
		426 => 'LS', // LSO
		430 => 'LR', // LBR
		144 => 'LK', // LKA
		438 => 'LI', // LIE
		662 => 'LC', // LCA
		422 => 'LB', // LBN
		418 => 'LA', // LAO
		398 => 'KZ', // KAZ
		136 => 'KY', // CYM
		414 => 'KW', // KWT
		410 => 'KR', // KOR
		408 => 'KP', // PRK
		659 => 'KN', // KNA
		174 => 'KM', // COM
		296 => 'KI', // KIR
		116 => 'KH', // KHM
		417 => 'KG', // KGZ
		404 => 'KE', // KEN
		392 => 'JP', // JPN
		400 => 'JO', // JOR
		388 => 'JM', // JAM
		832 => 'JE', // JEY
		380 => 'IT', // ITA
		352 => 'IS', // ISL
		364 => 'IR', // IRN
		368 => 'IQ', // IRQ
		86 => 'IO', // IOT
		356 => 'IN', // IND
		833 => 'IM', // IMN
		376 => 'IL', // ISR
		372 => 'IE', // IRL
		360 => 'ID', // IDN
		348 => 'HU', // HUN
		332 => 'HT', // HTI
		191 => 'HR', // HRV
		340 => 'HN', // HND
		334 => 'HM', // HMD
		344 => 'HK', // HKG
		328 => 'GY', // GUY
		624 => 'GW', // GNB
		316 => 'GU', // GUM
		320 => 'GT', // GTM
		239 => 'GS', // SGS
		300 => 'GR', // GRC
		226 => 'GQ', // GNQ
		312 => 'GP', // GLP
		324 => 'GN', // GIN
		270 => 'GM', // GMB
		304 => 'GL', // GRL
		292 => 'GI', // GIB
		288 => 'GH', // GHA
		831 => 'GG', // GGY
		254 => 'GF', // GUF
		268 => 'GE', // GEO
		308 => 'GD', // GRD
		826 => 'GB', // GBR
		266 => 'GA', // GAB
		250 => 'FR', // FRA
		234 => 'FO', // FRO
		583 => 'FM', // FSM
		238 => 'FK', // FLK
		242 => 'FJ', // FJI
		246 => 'FI', // FIN
		231 => 'ET', // ETH
		724 => 'ES', // ESP
		232 => 'ER', // ERI
		732 => 'EH', // ESH
		818 => 'EG', // EGY
		233 => 'EE', // EST
		218 => 'EC', // ECU
		012 => 'DZ', // DZA
		214 => 'DO', // DOM
		212 => 'DM', // DMA
		208 => 'DK', // DNK
		262 => 'DJ', // DJI
		276 => 'DE', // DEU
		203 => 'CZ', // CZE
		196 => 'CY', // CYP
		162 => 'CX', // CXR
		531 => 'CW', // CUW
		132 => 'CV', // CPV
		192 => 'CU', // CUB
		188 => 'CR', // CRI
		170 => 'CO', // COL
		156 => 'CN', // CHN
		120 => 'CM', // CMR
		152 => 'CL', // CHL
		184 => 'CK', // COK
		384 => 'CI', // CIV
		756 => 'CH', // CHE
		178 => 'CG', // COG
		140 => 'CF', // CAF
		180 => 'CD', // COD
		166 => 'CC', // CCK
		124 => 'CA', // CAN
		84 => 'BZ', // BLZ
		112 => 'BY', // BLR
		72 => 'BW', // BWA
		74 => 'BV', // BVT
		64 => 'BT', // BTN
		44 => 'BS', // BHS
		76 => 'BR', // BRA
		535 => 'BQ', // BES
		68 => 'BO', // BOL
		96 => 'BN', // BRN
		60 => 'BM', // BMU
		652 => 'BL', // BLM
		204 => 'BJ', // BEN
		108 => 'BI', // BDI
		48 => 'BH', // BHR
		100 => 'BG', // BGR
		854 => 'BF', // BFA
		56 => 'BE', // BEL
		50 => 'BD', // BGD
		52 => 'BB', // BRB
		70 => 'BA', // BIH
		31 => 'AZ', // AZE
		248 => 'AX', // ALA
		533 => 'AW', // ABW
		36 => 'AU', // AUS
		40 => 'AT', // AUT
		16 => 'AS', // ASM
		32 => 'AR', // ARG
		10 => 'AQ', // ATA
		24 => 'AO', // AGO
		51 => 'AM', // ARM
		8 => 'AL', // ALB
		660 => 'AI', // AIA
		28 => 'AG', // ATG
		4 => 'AF', // AFG
		784 => 'AE', // ARE
		20 => 'AD' // AND
	];

	const COUNTRY_FULL = [
		716 => [ 'iso2' => 'ZW', 'iso3' => 'ZWE', ],
		894 => [ 'iso2' => 'ZM', 'iso3' => 'ZMB', ],
		710 => [ 'iso2' => 'ZA', 'iso3' => 'ZAF', ],
		175 => [ 'iso2' => 'YT', 'iso3' => 'MYT', ],
		887 => [ 'iso2' => 'YE', 'iso3' => 'YEM', ],
		882 => [ 'iso2' => 'WS', 'iso3' => 'WSM', ],
		876 => [ 'iso2' => 'WF', 'iso3' => 'WLF', ],
		548 => [ 'iso2' => 'VU', 'iso3' => 'VUT', ],
		704 => [ 'iso2' => 'VN', 'iso3' => 'VNM', ],
		850 => [ 'iso2' => 'VI', 'iso3' => 'VIR', ],
		92 => [ 'iso2' => 'VG', 'iso3' => 'VGB', ],
		862 => [ 'iso2' => 'VE', 'iso3' => 'VEN', ],
		670 => [ 'iso2' => 'VC', 'iso3' => 'VCT', ],
		336 => [ 'iso2' => 'VA', 'iso3' => 'VAT', ],
		860 => [ 'iso2' => 'UZ', 'iso3' => 'UZB', ],
		858 => [ 'iso2' => 'UY', 'iso3' => 'URY', ],
		840 => [ 'iso2' => 'US', 'iso3' => 'USA', ],
		581 => [ 'iso2' => 'UM', 'iso3' => 'UMI', ],
		800 => [ 'iso2' => 'UG', 'iso3' => 'UGA', ],
		804 => [ 'iso2' => 'UA', 'iso3' => 'UKR', ],
		834 => [ 'iso2' => 'TZ', 'iso3' => 'TZA', ],
		158 => [ 'iso2' => 'TW', 'iso3' => 'TWN', ],
		798 => [ 'iso2' => 'TV', 'iso3' => 'TUV', ],
		780 => [ 'iso2' => 'TT', 'iso3' => 'TTO', ],
		792 => [ 'iso2' => 'TR', 'iso3' => 'TUR', ],
		776 => [ 'iso2' => 'TO', 'iso3' => 'TON', ],
		788 => [ 'iso2' => 'TN', 'iso3' => 'TUN', ],
		795 => [ 'iso2' => 'TM', 'iso3' => 'TKM', ],
		626 => [ 'iso2' => 'TL', 'iso3' => 'TLS', ],
		772 => [ 'iso2' => 'TK', 'iso3' => 'TKL', ],
		762 => [ 'iso2' => 'TJ', 'iso3' => 'TJK', ],
		764 => [ 'iso2' => 'TH', 'iso3' => 'THA', ],
		768 => [ 'iso2' => 'TG', 'iso3' => 'TGO', ],
		260 => [ 'iso2' => 'TF', 'iso3' => 'ATF', ],
		148 => [ 'iso2' => 'TD', 'iso3' => 'TCD', ],
		796 => [ 'iso2' => 'TC', 'iso3' => 'TCA', ],
		748 => [ 'iso2' => 'SZ', 'iso3' => 'SWZ', ],
		760 => [ 'iso2' => 'SY', 'iso3' => 'SYR', ],
		534 => [ 'iso2' => 'SX', 'iso3' => 'SXM', ],
		222 => [ 'iso2' => 'SV', 'iso3' => 'SLV', ],
		678 => [ 'iso2' => 'ST', 'iso3' => 'STP', ],
		728 => [ 'iso2' => 'SS', 'iso3' => 'SSD', ],
		740 => [ 'iso2' => 'SR', 'iso3' => 'SUR', ],
		706 => [ 'iso2' => 'SO', 'iso3' => 'SOM', ],
		686 => [ 'iso2' => 'SN', 'iso3' => 'SEN', ],
		674 => [ 'iso2' => 'SM', 'iso3' => 'SMR', ],
		694 => [ 'iso2' => 'SL', 'iso3' => 'SLE', ],
		703 => [ 'iso2' => 'SK', 'iso3' => 'SVK', ],
		744 => [ 'iso2' => 'SJ', 'iso3' => 'SJM', ],
		705 => [ 'iso2' => 'SI', 'iso3' => 'SVN', ],
		654 => [ 'iso2' => 'SH', 'iso3' => 'SHN', ],
		702 => [ 'iso2' => 'SG', 'iso3' => 'SGP', ],
		752 => [ 'iso2' => 'SE', 'iso3' => 'SWE', ],
		729 => [ 'iso2' => 'SD', 'iso3' => 'SDN', ],
		690 => [ 'iso2' => 'SC', 'iso3' => 'SYC', ],
		90 => [ 'iso2' => 'SB', 'iso3' => 'SLB', ],
		682 => [ 'iso2' => 'SA', 'iso3' => 'SAU', ],
		646 => [ 'iso2' => 'RW', 'iso3' => 'RWA', ],
		643 => [ 'iso2' => 'RU', 'iso3' => 'RUS', ],
		688 => [ 'iso2' => 'RS', 'iso3' => 'SRB', ],
		642 => [ 'iso2' => 'RO', 'iso3' => 'ROU', ],
		638 => [ 'iso2' => 'RE', 'iso3' => 'REU', ],
		634 => [ 'iso2' => 'QA', 'iso3' => 'QAT', ],
		600 => [ 'iso2' => 'PY', 'iso3' => 'PRY', ],
		585 => [ 'iso2' => 'PW', 'iso3' => 'PLW', ],
		620 => [ 'iso2' => 'PT', 'iso3' => 'PRT', ],
		275 => [ 'iso2' => 'PS', 'iso3' => 'PSE', ],
		630 => [ 'iso2' => 'PR', 'iso3' => 'PRI', ],
		612 => [ 'iso2' => 'PN', 'iso3' => 'PCN', ],
		666 => [ 'iso2' => 'PM', 'iso3' => 'SPM', ],
		616 => [ 'iso2' => 'PL', 'iso3' => 'POL', ],
		586 => [ 'iso2' => 'PK', 'iso3' => 'PAK', ],
		608 => [ 'iso2' => 'PH', 'iso3' => 'PHL', ],
		598 => [ 'iso2' => 'PG', 'iso3' => 'PNG', ],
		258 => [ 'iso2' => 'PF', 'iso3' => 'PYF', ],
		604 => [ 'iso2' => 'PE', 'iso3' => 'PER', ],
		591 => [ 'iso2' => 'PA', 'iso3' => 'PAN', ],
		512 => [ 'iso2' => 'OM', 'iso3' => 'OMN', ],
		554 => [ 'iso2' => 'NZ', 'iso3' => 'NZL', ],
		570 => [ 'iso2' => 'NU', 'iso3' => 'NIU', ],
		520 => [ 'iso2' => 'NR', 'iso3' => 'NRU', ],
		524 => [ 'iso2' => 'NP', 'iso3' => 'NPL', ],
		578 => [ 'iso2' => 'NO', 'iso3' => 'NOR', ],
		528 => [ 'iso2' => 'NL', 'iso3' => 'NLD', ],
		558 => [ 'iso2' => 'NI', 'iso3' => 'NIC', ],
		566 => [ 'iso2' => 'NG', 'iso3' => 'NGA', ],
		574 => [ 'iso2' => 'NF', 'iso3' => 'NFK', ],
		562 => [ 'iso2' => 'NE', 'iso3' => 'NER', ],
		540 => [ 'iso2' => 'NC', 'iso3' => 'NCL', ],
		516 => [ 'iso2' => 'NA', 'iso3' => 'NAM', ],
		508 => [ 'iso2' => 'MZ', 'iso3' => 'MOZ', ],
		458 => [ 'iso2' => 'MY', 'iso3' => 'MYS', ],
		484 => [ 'iso2' => 'MX', 'iso3' => 'MEX', ],
		454 => [ 'iso2' => 'MW', 'iso3' => 'MWI', ],
		462 => [ 'iso2' => 'MV', 'iso3' => 'MDV', ],
		480 => [ 'iso2' => 'MU', 'iso3' => 'MUS', ],
		470 => [ 'iso2' => 'MT', 'iso3' => 'MLT', ],
		500 => [ 'iso2' => 'MS', 'iso3' => 'MSR', ],
		478 => [ 'iso2' => 'MR', 'iso3' => 'MRT', ],
		474 => [ 'iso2' => 'MQ', 'iso3' => 'MTQ', ],
		580 => [ 'iso2' => 'MP', 'iso3' => 'MNP', ],
		446 => [ 'iso2' => 'MO', 'iso3' => 'MAC', ],
		496 => [ 'iso2' => 'MN', 'iso3' => 'MNG', ],
		104 => [ 'iso2' => 'MM', 'iso3' => 'MMR', ],
		466 => [ 'iso2' => 'ML', 'iso3' => 'MLI', ],
		807 => [ 'iso2' => 'MK', 'iso3' => 'MKD', ],
		584 => [ 'iso2' => 'MH', 'iso3' => 'MHL', ],
		450 => [ 'iso2' => 'MG', 'iso3' => 'MDG', ],
		663 => [ 'iso2' => 'MF', 'iso3' => 'MAF', ],
		499 => [ 'iso2' => 'ME', 'iso3' => 'MNE', ],
		498 => [ 'iso2' => 'MD', 'iso3' => 'MDA', ],
		492 => [ 'iso2' => 'MC', 'iso3' => 'MCO', ],
		504 => [ 'iso2' => 'MA', 'iso3' => 'MAR', ],
		434 => [ 'iso2' => 'LY', 'iso3' => 'LBY', ],
		428 => [ 'iso2' => 'LV', 'iso3' => 'LVA', ],
		442 => [ 'iso2' => 'LU', 'iso3' => 'LUX', ],
		440 => [ 'iso2' => 'LT', 'iso3' => 'LTU', ],
		426 => [ 'iso2' => 'LS', 'iso3' => 'LSO', ],
		430 => [ 'iso2' => 'LR', 'iso3' => 'LBR', ],
		144 => [ 'iso2' => 'LK', 'iso3' => 'LKA', ],
		438 => [ 'iso2' => 'LI', 'iso3' => 'LIE', ],
		662 => [ 'iso2' => 'LC', 'iso3' => 'LCA', ],
		422 => [ 'iso2' => 'LB', 'iso3' => 'LBN', ],
		418 => [ 'iso2' => 'LA', 'iso3' => 'LAO', ],
		398 => [ 'iso2' => 'KZ', 'iso3' => 'KAZ', ],
		136 => [ 'iso2' => 'KY', 'iso3' => 'CYM', ],
		414 => [ 'iso2' => 'KW', 'iso3' => 'KWT', ],
		410 => [ 'iso2' => 'KR', 'iso3' => 'KOR', ],
		408 => [ 'iso2' => 'KP', 'iso3' => 'PRK', ],
		659 => [ 'iso2' => 'KN', 'iso3' => 'KNA', ],
		174 => [ 'iso2' => 'KM', 'iso3' => 'COM', ],
		296 => [ 'iso2' => 'KI', 'iso3' => 'KIR', ],
		116 => [ 'iso2' => 'KH', 'iso3' => 'KHM', ],
		417 => [ 'iso2' => 'KG', 'iso3' => 'KGZ', ],
		404 => [ 'iso2' => 'KE', 'iso3' => 'KEN', ],
		392 => [ 'iso2' => 'JP', 'iso3' => 'JPN', ],
		400 => [ 'iso2' => 'JO', 'iso3' => 'JOR', ],
		388 => [ 'iso2' => 'JM', 'iso3' => 'JAM', ],
		832 => [ 'iso2' => 'JE', 'iso3' => 'JEY', ],
		380 => [ 'iso2' => 'IT', 'iso3' => 'ITA', ],
		352 => [ 'iso2' => 'IS', 'iso3' => 'ISL', ],
		364 => [ 'iso2' => 'IR', 'iso3' => 'IRN', ],
		368 => [ 'iso2' => 'IQ', 'iso3' => 'IRQ', ],
		86 => [ 'iso2' => 'IO', 'iso3' => 'IOT', ],
		356 => [ 'iso2' => 'IN', 'iso3' => 'IND', ],
		833 => [ 'iso2' => 'IM', 'iso3' => 'IMN', ],
		376 => [ 'iso2' => 'IL', 'iso3' => 'ISR', ],
		372 => [ 'iso2' => 'IE', 'iso3' => 'IRL', ],
		360 => [ 'iso2' => 'ID', 'iso3' => 'IDN', ],
		348 => [ 'iso2' => 'HU', 'iso3' => 'HUN', ],
		332 => [ 'iso2' => 'HT', 'iso3' => 'HTI', ],
		191 => [ 'iso2' => 'HR', 'iso3' => 'HRV', ],
		340 => [ 'iso2' => 'HN', 'iso3' => 'HND', ],
		334 => [ 'iso2' => 'HM', 'iso3' => 'HMD', ],
		344 => [ 'iso2' => 'HK', 'iso3' => 'HKG', ],
		328 => [ 'iso2' => 'GY', 'iso3' => 'GUY', ],
		624 => [ 'iso2' => 'GW', 'iso3' => 'GNB', ],
		316 => [ 'iso2' => 'GU', 'iso3' => 'GUM', ],
		320 => [ 'iso2' => 'GT', 'iso3' => 'GTM', ],
		239 => [ 'iso2' => 'GS', 'iso3' => 'SGS', ],
		300 => [ 'iso2' => 'GR', 'iso3' => 'GRC', ],
		226 => [ 'iso2' => 'GQ', 'iso3' => 'GNQ', ],
		312 => [ 'iso2' => 'GP', 'iso3' => 'GLP', ],
		324 => [ 'iso2' => 'GN', 'iso3' => 'GIN', ],
		270 => [ 'iso2' => 'GM', 'iso3' => 'GMB', ],
		304 => [ 'iso2' => 'GL', 'iso3' => 'GRL', ],
		292 => [ 'iso2' => 'GI', 'iso3' => 'GIB', ],
		288 => [ 'iso2' => 'GH', 'iso3' => 'GHA', ],
		831 => [ 'iso2' => 'GG', 'iso3' => 'GGY', ],
		254 => [ 'iso2' => 'GF', 'iso3' => 'GUF', ],
		268 => [ 'iso2' => 'GE', 'iso3' => 'GEO', ],
		308 => [ 'iso2' => 'GD', 'iso3' => 'GRD', ],
		826 => [ 'iso2' => 'GB', 'iso3' => 'GBR', ],
		266 => [ 'iso2' => 'GA', 'iso3' => 'GAB', ],
		250 => [ 'iso2' => 'FR', 'iso3' => 'FRA', ],
		234 => [ 'iso2' => 'FO', 'iso3' => 'FRO', ],
		583 => [ 'iso2' => 'FM', 'iso3' => 'FSM', ],
		238 => [ 'iso2' => 'FK', 'iso3' => 'FLK', ],
		242 => [ 'iso2' => 'FJ', 'iso3' => 'FJI', ],
		246 => [ 'iso2' => 'FI', 'iso3' => 'FIN', ],
		231 => [ 'iso2' => 'ET', 'iso3' => 'ETH', ],
		724 => [ 'iso2' => 'ES', 'iso3' => 'ESP', ],
		232 => [ 'iso2' => 'ER', 'iso3' => 'ERI', ],
		732 => [ 'iso2' => 'EH', 'iso3' => 'ESH', ],
		818 => [ 'iso2' => 'EG', 'iso3' => 'EGY', ],
		233 => [ 'iso2' => 'EE', 'iso3' => 'EST', ],
		218 => [ 'iso2' => 'EC', 'iso3' => 'ECU', ],
		012 => [ 'iso2' => 'DZ', 'iso3' => 'DZA', ],
		214 => [ 'iso2' => 'DO', 'iso3' => 'DOM', ],
		212 => [ 'iso2' => 'DM', 'iso3' => 'DMA', ],
		208 => [ 'iso2' => 'DK', 'iso3' => 'DNK', ],
		262 => [ 'iso2' => 'DJ', 'iso3' => 'DJI', ],
		276 => [ 'iso2' => 'DE', 'iso3' => 'DEU', ],
		203 => [ 'iso2' => 'CZ', 'iso3' => 'CZE', ],
		196 => [ 'iso2' => 'CY', 'iso3' => 'CYP', ],
		162 => [ 'iso2' => 'CX', 'iso3' => 'CXR', ],
		531 => [ 'iso2' => 'CW', 'iso3' => 'CUW', ],
		132 => [ 'iso2' => 'CV', 'iso3' => 'CPV', ],
		192 => [ 'iso2' => 'CU', 'iso3' => 'CUB', ],
		188 => [ 'iso2' => 'CR', 'iso3' => 'CRI', ],
		170 => [ 'iso2' => 'CO', 'iso3' => 'COL', ],
		156 => [ 'iso2' => 'CN', 'iso3' => 'CHN', ],
		120 => [ 'iso2' => 'CM', 'iso3' => 'CMR', ],
		152 => [ 'iso2' => 'CL', 'iso3' => 'CHL', ],
		184 => [ 'iso2' => 'CK', 'iso3' => 'COK', ],
		384 => [ 'iso2' => 'CI', 'iso3' => 'CIV', ],
		756 => [ 'iso2' => 'CH', 'iso3' => 'CHE', ],
		178 => [ 'iso2' => 'CG', 'iso3' => 'COG', ],
		140 => [ 'iso2' => 'CF', 'iso3' => 'CAF', ],
		180 => [ 'iso2' => 'CD', 'iso3' => 'COD', ],
		166 => [ 'iso2' => 'CC', 'iso3' => 'CCK', ],
		124 => [ 'iso2' => 'CA', 'iso3' => 'CAN', ],
		84 => [ 'iso2' => 'BZ', 'iso3' => 'BLZ', ],
		112 => [ 'iso2' => 'BY', 'iso3' => 'BLR', ],
		72 => [ 'iso2' => 'BW', 'iso3' => 'BWA', ],
		74 => [ 'iso2' => 'BV', 'iso3' => 'BVT', ],
		64 => [ 'iso2' => 'BT', 'iso3' => 'BTN', ],
		44 => [ 'iso2' => 'BS', 'iso3' => 'BHS', ],
		76 => [ 'iso2' => 'BR', 'iso3' => 'BRA', ],
		535 => [ 'iso2' => 'BQ', 'iso3' => 'BES', ],
		68 => [ 'iso2' => 'BO', 'iso3' => 'BOL', ],
		96 => [ 'iso2' => 'BN', 'iso3' => 'BRN', ],
		60 => [ 'iso2' => 'BM', 'iso3' => 'BMU', ],
		652 => [ 'iso2' => 'BL', 'iso3' => 'BLM', ],
		204 => [ 'iso2' => 'BJ', 'iso3' => 'BEN', ],
		108 => [ 'iso2' => 'BI', 'iso3' => 'BDI', ],
		48 => [ 'iso2' => 'BH', 'iso3' => 'BHR', ],
		100 => [ 'iso2' => 'BG', 'iso3' => 'BGR', ],
		854 => [ 'iso2' => 'BF', 'iso3' => 'BFA', ],
		56 => [ 'iso2' => 'BE', 'iso3' => 'BEL', ],
		50 => [ 'iso2' => 'BD', 'iso3' => 'BGD', ],
		52 => [ 'iso2' => 'BB', 'iso3' => 'BRB', ],
		70 => [ 'iso2' => 'BA', 'iso3' => 'BIH', ],
		31 => [ 'iso2' => 'AZ', 'iso3' => 'AZE', ],
		248 => [ 'iso2' => 'AX', 'iso3' => 'ALA', ],
		533 => [ 'iso2' => 'AW', 'iso3' => 'ABW', ],
		36 => [ 'iso2' => 'AU', 'iso3' => 'AUS', ],
		40 => [ 'iso2' => 'AT', 'iso3' => 'AUT', ],
		16 => [ 'iso2' => 'AS', 'iso3' => 'ASM', ],
		32 => [ 'iso2' => 'AR', 'iso3' => 'ARG', ],
		10 => [ 'iso2' => 'AQ', 'iso3' => 'ATA', ],
		24 => [ 'iso2' => 'AO', 'iso3' => 'AGO', ],
		51 => [ 'iso2' => 'AM', 'iso3' => 'ARM', ],
		8 => [ 'iso2' => 'AL', 'iso3' => 'ALB', ],
		660 => [ 'iso2' => 'AI', 'iso3' => 'AIA', ],
		28 => [ 'iso2' => 'AG', 'iso3' => 'ATG', ],
		4 => [ 'iso2' => 'AF', 'iso3' => 'AFG', ],
		784 => [ 'iso2' => 'AE', 'iso3' => 'ARE', ],
		20 => [ 'iso2' => 'AD', 'iso3' => 'AND', ],
	];

/*<<<<<CLASS_END*/
} // class world-reposController
/*>>>>>CLASS_END*/
