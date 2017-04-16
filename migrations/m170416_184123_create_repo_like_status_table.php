<?php

use yii\db\Migration;

/**
 * Handles the creation of table `repo_like_status`.
 */
class m170416_184123_create_repo_like_status_table extends Migration
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

        $this->createTable('{{%repo_like_status}}', [
            'id' => $this->primaryKey(),
            'repo_id' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
        ], $tableOptions);

        $this->createIndex('idx_repo_like_status_name', '{{%repo_like_status}}', 'repo_id');
        $this->createIndex('idx_repo_like_status_status', '{{%repo_like_status}}', 'status');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('repo_like_status');
    }
}
