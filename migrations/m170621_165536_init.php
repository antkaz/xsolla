<?php

use yii\db\Migration;

class m170621_165536_init extends Migration
{
    private $userTable = '{{%user}}';
    private $fileTable = '{{%file}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->userTable, [
            'user_id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'password_hash' => $this->string()->notNull(),
            'access_token' => $this->string()->null(),
            'allowance' => $this->integer()->null(),
            'allowance_updated_at' => $this->integer()->null(),
            'quote' => $this->integer()->null(),
                ], $tableOptions);
        $this->createIndex('uidx-user-username', $this->userTable, 'username', true);
        $this->createIndex('uidx-user-access_token', $this->userTable, 'access_token', true);

        $this->createTable($this->fileTable, [
            'file_id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'filename' => $this->string()->notNull(),
                ], $tableOptions);
        $this->createIndex('idx-file-user_id', $this->fileTable, 'user_id');

        $this->addForeignKey('fk_user_file', $this->fileTable, 'user_id', $this->userTable, 'user_id', 'CASCADE', 'CASCADE');

        $this->insert($this->userTable, [
            'username' => 'xsolla',
            'password_hash' => '$2y$13$.sF4F.GNYZKYokAJ0HUrou2rxYKvUeWSlbvf2zytrKr4P8DRN423q', // 123456789
        ]);
    }

    public function down()
    {
        $this->delete($this->userTable, ['user_id' => 1]);
        
        $this->dropForeignKey('fk_user_file', $this->fileTable);
        
        $this->dropTable($this->fileTable);
        $this->dropTable($this->userTable);
    }

}
