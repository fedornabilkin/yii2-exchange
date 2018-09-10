<?php

use yii\db\Migration;

/**
 * Handles the creation of table `exchange`.
 */
class m180606_111944_create_exchange_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%exchange}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'type' => $this->char(50),
            'credit' => $this->float()->defaultValue(0)->unsigned(),
            'amount' => $this->float()->defaultValue(0)->unsigned(),
            'updated_at' => $this->integer()->defaultValue(0)->unsigned(),
            'created_at' => $this->integer()->notNull()->unsigned(),
        ], $tableOptions);

        $this->createIndex('{{%idx_exchange_type}}', '{{%exchange}}', 'type');

        $this->addForeignKey(
            '{{%fki_exchange_user}}',
            '{{%exchange}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fki_exchange_user}}', '{{%exchange}}');
        $this->dropIndex('{{%idx_exchange_type}}', '{{%exchange}}');

        $this->dropTable('{{%exchange}}');
    }
}
