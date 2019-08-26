<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%message}}`.
 */
class m190826_113041_create_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%message}}', [
            'id' => $this->primaryKey(),
            'sender_id' => $this->integer()->notNull(),
            'recipient_id' => $this->integer()->notNull(),
            'subject' => $this->string(255)->notNull(),
            'body' => $this->text(),
            'status' => $this->integer()->notNull(),
        ]);

        // creates index and fk for column `sender_id`
        $this->createIndex(
            'idx-message-sender_id',
            '{{%message}}',
            'sender_id'
        );
        $this->addForeignKey(
            'fk-message-sender_id',
            '{{%message}}',
            'sender_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index and fk for column `sender_id`
        $this->createIndex(
            'idx-message-recipient_id',
            '{{%message}}',
            'recipient_id'
        );
        $this->addForeignKey(
            'fk-message-recipient_id',
            '{{%message}}',
            'recipient_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key and index for column `sender_id`
        $this->dropForeignKey(
            'fk-message-sender_id',
            '{{%message}}'
        );
        $this->dropIndex(
            'idx-message-sender_id',
            '{{%message}}'
        );

        // drops foreign key and index for column `recipient_id`
        $this->dropForeignKey(
            'fk-message-recipient_id',
            '{{%message}}'
        );
        $this->dropIndex(
            'idx-message-recipient_id',
            '{{%message}}'
        );

        $this->dropTable('{{%message}}');
    }
}
