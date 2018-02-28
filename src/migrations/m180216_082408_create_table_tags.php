<?php

use yii\db\Migration;

class m180216_082408_create_table_tags extends Migration
{
    const TABLE_NAME = '{{%tags}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable(self::TABLE_NAME, [
            '[[tag_id]]' =>'pk',
            '[[tag]]' => $this->string(255)->unique(),
        ], $tableOptions);

        /*
      * Создание индекса
      * Языка - tags
      */
        $this->createIndex(
            'idx-tags-tags-tag',
            '{{%tags}}',
            '[[tag]]'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}