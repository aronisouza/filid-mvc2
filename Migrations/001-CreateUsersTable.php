<?php

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->createTable('users', [
            '`id` INT AUTO_INCREMENT PRIMARY KEY',
            '`nome` VARCHAR(255) NOT NULL',
            '`email` VARCHAR(255) NOT NULL UNIQUE',
            '`senha_hash` VARCHAR(255) NOT NULL',
            '`status` ENUM("active", "inactive") NOT NULL DEFAULT "active"',
            '`role` ENUM("admin", "user") NOT NULL DEFAULT "user"',
            '`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            '`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ]);
        $this->addIndex('users', 'idx_user_email', 'email');
        $this->addIndex('users', 'idx_user_status', 'status');
    }

    public function down()
    {
        $this->dropTable('users');
    }
}
