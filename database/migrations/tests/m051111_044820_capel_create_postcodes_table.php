<?php
/*<<<<<USES*/
/*Template:Yii2App/database/migration.php*/
use yii\db\Migration;
/*>>>>>USES*/
/*<<<<<CLASS*/
/**
 * Class m051111_044820_capel_create_postcodes_table
 * if you encounter foreign key constraint errors while altering a table with data,
 * set YII2_SQLITE3_DISABLE_FOREIGN_CHECKS=1 before running the migrate command
 */
class m051111_044820_capel_create_postcodes_table extends Migration
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
		$this->createTable('{{%postcodes}}', [
/*>>>>>CREATE_TABLE*/
/*<<<<<COLUMNS*/
			'postcode' => $this->string(10)->notNull(),
			'places_id' => $this->integer()->notNull(),
/*>>>>>COLUMNS*/
/*<<<<<END_CREATE_TABLE*/
		// add more fields here
		], $tableOptions);
/*>>>>>END_CREATE_TABLE*/
/*<<<<<CREATE_CONSTRAINTS*/

		// creates index for relation place
		$this->createIndex(
            'yii2idx-postcodes-places_id',
            '{{%postcodes}}',
            'places_id'
		); // indexes
		$this->addForeignKey(
			'yii2fk-postcodes-places_id',
			'{{%postcodes}}',
			'places_id',
			'places',
			'id',
			'RESTRICT',
			'RESTRICT'
		); // foreign
/*>>>>>CREATE_CONSTRAINTS*/
/*<<<<<SAFE_DOWN*/
    } // safeup

	public function safeDown()
	{
/*>>>>>SAFE_DOWN*/
/*<<<<<DROP*/
		$this->dropTable('{{%postcodes}}'); // down_element
/*>>>>>DROP*/
/*<<<<<END*/
	}
} // class m051111_044820_capel_create_postcodes_table
/*>>>>>END*/
