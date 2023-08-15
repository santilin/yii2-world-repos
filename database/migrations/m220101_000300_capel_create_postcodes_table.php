<?php
/*<<<<<USES*/
/*Template:Yii2App/database/migration.php*/
use yii\db\Migration;
/*>>>>>USES*/
/*<<<<<CLASS*/
/**
 * Class m220101_000300_capel_create_postcodes_table
 */
class m220101_000300_capel_create_postcodes_table extends Migration
{
/*>>>>>CLASS*/
/*<<<<<SAFE_UP*/
	public function up()
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
			'postcode' => $this->decimal(12)->notNull()->defaultValue(0.0),
			'places_id' => $this->tinyInteger()->notNull(),
/*>>>>>COLUMNS*/
/*<<<<<END_CREATE_TABLE*/
		// add more fields here
		], $tableOptions);
/*>>>>>END_CREATE_TABLE*/
/*<<<<<CREATE_CONSTRAINTS*/
		// creates index for relation places_id
		$this->createIndex(
            'yii2idx-postcodes-places_id',
            '{{%postcodes}}',
            'places_id'
		);
		$this->addForeignKey(
            'yii2fk-postcodes-places_id',
            '{{%postcodes}}',
            'places_id',
            '{{%places}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
/*>>>>>CREATE_CONSTRAINTS*/
/*<<<<<SAFE_DOWN*/
    } // safeup

	public function down()
	{
/*>>>>>SAFE_DOWN*/
/*<<<<<DROP*/
		$this->dropTable('{{%postcodes}}');
/*>>>>>DROP*/
/*<<<<<END*/
	}
} // class m220101_000300_capel_create_postcodes_table
/*>>>>>END*/