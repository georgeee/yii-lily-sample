<?php

class m130118_140222_sample_tables extends CDbMigration {

    public function safeUp() {
        $options = null;
        if ($this->dbConnection->driverName == 'mysql')
            $options = 'ENGINE=InnoDB';
        $this->createTable('{{profile}}', array(
            'pid' => 'pk',
            'uid' => 'integer',
            'name' => 'string',
            'username' => 'string',
            'about' => 'text',
            'merged' => 'boolean'
                ), $options);
        $this->createTable('{{article}}', array(
            'aid' => 'pk',
            'uid' => 'integer',
            'title' => 'string',
            'body' => 'text',
            'updated' => 'integer',
            'created' => 'integer',
                ), $options);
        $this->createTable('{{merge_history}}', array(
            'hid' => 'pk',
            'donor_id' => 'integer',
            'acceptor_id' => 'integer',
            'owner_id' => 'integer',
            'time' => 'integer',
            'account' => 'binary',
                ), $options);
    }

    public function safeDown() {
        $this->dropTable('{{merge_history}}');
        $this->dropTable('{{article}}');
        $this->dropTable('{{profile}}');
    }

}