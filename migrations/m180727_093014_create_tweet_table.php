<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tweet`.
 */
class m180727_093014_create_tweet_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tweet', [
            'id' => $this->primaryKey(),
            'author' => $this->string()->notNull(),
            'date' => $this->dateTime()->notNull(),
            'body' => $this->string(280)->notNull(),
            'lat' => $this->double()->notNull(),
            'lng' => $this->double()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('tweet');
    }
}
