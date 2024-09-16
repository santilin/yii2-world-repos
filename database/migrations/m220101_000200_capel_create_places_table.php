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
		$this->createTable('{{%places}}', [
/*>>>>>CREATE_TABLE*/
/*<<<<<COLUMNS*/
			'id' => $this->integer()->notNull() . ' ' . $this->db->getSchema()->createQueryBuilder()->buildExpression(new \yii\db\Expression('AUTO_INCREMENT')),
			'name' => $this->string()->notNull(),
			'level' => $this->tinyInteger()->notNull()->defaultValue(0),
			'name_es' => $this->string()->null(),
			'name_en' => $this->string()->null(),
			'name_fr' => $this->string()->null(),
			'admin_code' => $this->string()->null(),
			'admin_sup_code' => $this->string()->null(),
			'admin_sup_name' => $this->string()->null(),
			'national_id' => $this->string()->null(),
			'countries_id' => $this->smallInteger()->notNull(),
			'PRIMARY KEY (id)',
/*>>>>>COLUMNS*/
/*<<<<<END_CREATE_TABLE*/
		// add more fields here
		], $tableOptions);
/*>>>>>END_CREATE_TABLE*/
/*<<<<<CREATE_CONSTRAINTS*/

		// creates index for column name
		$this->createIndex(
            'yii2idx-places-name',
            '{{%places}}',
            'name' );
		// creates index for relation country
		$this->createIndex(
            'yii2idx-places-countries_id',
            '{{%places}}',
            'countries_id'
		); // indexes
		$this->addForeignKey(
            'yii2fk-places-countries_id',
            '{{%places}}',
            'countries_id',
            '{{%countries}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        ); // foreign
/*>>>>>CREATE_CONSTRAINTS*/
/*<<<<<SAFE_DOWN*/
    } // safeup

	public function down()
	{
/*>>>>>SAFE_DOWN*/
/*<<<<<DROP*/
		$this->dropTable('{{%places}}'); // down_element
/*>>>>>DROP*/
/*<<<<<END*/
	}
} // class m220101_000200_capel_create_places_table
/*>>>>>END*/
