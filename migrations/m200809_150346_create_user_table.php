<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m200809_150346_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey()->comment('Код'),
            'username' => $this->string()->notNull()->unique()->comment('Имя пользователя'),
            'auth_key' => $this->string(32)->notNull()->comment('Аунтификационный ключ'),
            'password_hash' => $this->string()->notNull()->comment('Хэш пароля'),
            'password_reset_token' => $this->string()->unique()->comment('Токеен для восстановления пароля'),
            'email' => $this->string()->notNull()->unique()->comment('E-mail'),
            'deleted' => $this->boolean()->notNull()->defaultValue(false)->comment('Удален'),
            'created_at' => $this->integer()->notNull()->comment('Дата создания'),
            'updated_at' => $this->integer()->notNull()->comment('Дата изменения'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
