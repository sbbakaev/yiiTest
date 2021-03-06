<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_like_status`.
 */
class m170414_135422_create_user_like_status_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_like_status}}', [
            'id' => $this->primaryKey(),
            'login' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
        ], $tableOptions);

        $this->createIndex('idx_user_like_status_name', '{{%user_like_status}}', 'login');
        $this->createIndex('idx_user_like_status_status', '{{%user_like_status}}', 'status');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        echo "m170414_135422 create repo like status table cannot be reverted.\n";
        return false;
    }
}
