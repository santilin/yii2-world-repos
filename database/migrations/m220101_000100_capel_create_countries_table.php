<?php
/*<<<<<USES*/
/*Template:Yii2App/database/migration.php*/
use yii\db\Migration;
/*>>>>>USES*/
/*<<<<<CLASS*/
/**
 * Class m220101_000100_capel_create_countries_table
 */
class m220101_000100_capel_create_countries_table extends Migration
{
/*>>>>>CLASS*/
/*<<<<<SAFE_UP*/
	public function safeUp()
	{
/*>>>>>SAFE_UP*/
/*<<<<<TABLEOPTIONS*/
		$tableOptions = '';
		if ($this->db->driverName === 'mysql') {
            $tableOptions = 'ENGINE=InnoDB CHARSET utf8mb4 COLLATE utf8mb4_spanish_ci';
        }
/*>>>>>TABLEOPTIONS*/
/*<<<<<CREATE_TABLE*/
		$this->createTable('{{%countries}}', [
/*>>>>>CREATE_TABLE*/
/*<<<<<COLUMNS*/
			'id' => $this->tinyInteger()->notNull() . ' PRIMARY KEY',
			'iso2' => $this->char(2)->notNull(),
			'iso3' => $this->char(3)->notNull(),
			'name' => $this->string()->null(),
			'name_es' => $this->string()->null(),
			'name_en' => $this->string()->null(),
			'name_fr' => $this->string()->null(),
/*>>>>>COLUMNS*/
/*<<<<<END_CREATE_TABLE*/
		// add more fields here
		], $tableOptions);
/*>>>>>END_CREATE_TABLE*/
/*<<<<<CREATE_CONSTRAINTS*/
		// creates index for column iso2
		$this->createIndex(
            'yii2idx-countries-iso2',
            '{{%countries}}',
            'iso2' );
		// creates index for column name
		$this->createIndex(
            'yii2idx-countries-name',
            '{{%countries}}',
            'name' );
		// creates index for column name_es
		$this->createIndex(
            'yii2idx-countries-name_es',
            '{{%countries}}',
            'name_es' );
		// creates index for column name_en
		$this->createIndex(
            'yii2idx-countries-name_en',
            '{{%countries}}',
            'name_en' );
		// creates index for column name_fr
		$this->createIndex(
            'yii2idx-countries-name_fr',
            '{{%countries}}',
            'name_fr' );
/*>>>>>CREATE_CONSTRAINTS*/
/*<<<<<SAFE_DOWN*/
    } // safeup

	public function safeDown()
	{
/*>>>>>SAFE_DOWN*/
/*<<<<<DROP*/
		$this->dropTable('{{%countries}}');
/*>>>>>DROP*/
/*<<<<<END*/
	}
} // class m220101_000100_capel_create_countries_table
/*>>>>>END*/
