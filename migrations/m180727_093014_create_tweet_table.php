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
            'tweet_id' => $this->string(50)->unique()->notNull(),
            'author' => $this->string()->notNull(),
            'date' => $this->dateTime()->notNull(),
            'body' => $this->string(280)->notNull(),
            'lat' => $this->double()->notNull(),
            'lng' => $this->double()->notNull(),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('tweet');
    }
}
