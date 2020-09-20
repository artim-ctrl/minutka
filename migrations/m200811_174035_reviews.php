<?php

use yii\db\Migration;

/**
 * Class m200811_174035_reviews
 */
class m200811_174035_reviews extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%reviews}}', [
            'id' => $this->primaryKey()->comment('Код'),
            'user_id' => $this->integer()->notNull()->comment('Код пользователя'),
            'review_id' => $this->integer()->Null()->comment('Код комментария'),
            'content' => $this->text()->notNull()->comment('Содержание'),
            'deleted' => $this->boolean()->notNull()->defaultValue(false)->comment('Удален'),
            'created_at' => $this->integer()->notNull()->comment('Дата создания'),
            'updated_at' => $this->integer()->notNull()->comment('Дата изменения'),
        ]);

        $this->createIndex(
            'i_reviews_user_id',
            'reviews',
            'user_id'
        );

        $this->addForeignKey(
            'fk_reviews_user_id',
            'reviews',
            'user_id',
            'user',
            'id',
            'CASCADE', 'CASCADE'
        );

        $this->createIndex(
            'i_reviews_review_id',
            'reviews',
            'review_id'
        );

        $this->addForeignKey(
            'fk_reviews_review_id',
            'reviews',
            'review_id',
            'reviews',
            'id',
            'CASCADE', 'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk_reviews_user_id',
            'reviews'
        );

        $this->dropForeignKey(
            'fk_reviews_review_id',
            'reviews'
        );

        $this->dropTable('{{%reviews}}');
    }
}
