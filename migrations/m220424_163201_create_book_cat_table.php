<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book_cat}}`.
 */
class m220424_163201_create_book_cat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book_cat}}', [
            'id' => $this->primaryKey(),
            'book_id' => $this->integer()->notNull(),
            'cat_id' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%book_cat}}');
    }
}
