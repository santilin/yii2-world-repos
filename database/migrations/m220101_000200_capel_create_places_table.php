<?php
/*<<<<<USES*/
/*Template:Yii2App/database/migration.php*/
use yii\db\Migration;
/*>>>>>USES*/
/*<<<<<CLASS*/
/**
 * Class m220101_000200_capel_create_places_table
 */
class m220101_000200_capel_create_places_table extends Migration
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
		$this->createTable('{{%places}}', [
/*>>>>>CREATE_TABLE*/
/*<<<<<COLUMNS*/
			'id' => $this->tinyInteger()->notNull() . ' PRIMARY KEY',
			'contry_code' => $this->string(2)->notNull(),
			'name' => $this->string()->notNull(),
			'nuts_code' => $this->string()->null(),
			'nuts3_id' => $this->string()->null(),
			'city_name' => $this->string()->null(),
			'greater_city' => $this->string()->null(),
			'city_id' => $this->string()->null(),
			'lau_id' => $this->string()->null(),
			'fua_id' => $this->string()->null(),
/*>>>>>COLUMNS*/
/*<<<<<END_CREATE_TABLE*/
		// add more fields here
		], $tableOptions);
/*>>>>>END_CREATE_TABLE*/
/*<<<<<CREATE_CONSTRAINTS*/
		// creates index for column contry_code
		$this->createIndex(
            'yii2idx-places-contry_code',
            '{{%places}}',
            'contry_code' );
		// creates index for column name
		$this->createIndex(
            'yii2idx-places-name',
            '{{%places}}',
            'name' );
/*>>>>>CREATE_CONSTRAINTS*/
/*<<<<<SAFE_DOWN*/
    } // safeup

	public function safeDown()
	{
/*>>>>>SAFE_DOWN*/
/*<<<<<DROP*/
		$this->dropTable('{{%places}}');
/*>>>>>DROP*/
/*<<<<<END*/
	}
} // class m220101_000200_capel_create_places_table
/*>>>>>END*/
