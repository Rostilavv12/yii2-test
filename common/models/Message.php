<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "message".
 *
 * @property int $id
 * @property int $sender_id
 * @property int $recipient_id
 * @property string $subject
 * @property string $body
 * @property int $status
 *
 * @property User $recipient
 * @property User $sender
 */
class Message extends ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_READ = 1;

    /**
     * get array of name statuses
     *
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_NEW => Yii::t('app', 'Новое'),
            self::STATUS_READ => Yii::t('app', 'Прочитанное'),
        ];
    }

    /**
     * get name of current status message
     *
     * @return string
     */
    public function getNameStatus()
    {
        return (self::getStatuses())[$this->status] ?? '';
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['sender_id', 'default', 'value' => Yii::$app->user->id],
            ['status', 'default', 'value' => self::STATUS_NEW],
            [['sender_id', 'recipient_id', 'subject', 'status'], 'required'],
            [['sender_id', 'recipient_id', 'status'], 'integer'],
            [['body'], 'string'],
            [['subject'], 'string', 'max' => 255],
            [['recipient_id'], 'exist', 'skipOnError' => true,
                'targetClass' => User::class, 'targetAttribute' => ['recipient_id' => 'id']],
            [['sender_id'], 'exist', 'skipOnError' => true,
                'targetClass' => User::class, 'targetAttribute' => ['sender_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sender_id' => Yii::t('app', 'Sender ID'),
            'recipient_id' => Yii::t('app', 'Recipient ID'),
            'subject' => Yii::t('app', 'Subject'),
            'body' => Yii::t('app', 'Body'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipient()
    {
        return $this->hasOne(User::class, ['id' => 'recipient_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(User::class, ['id' => 'sender_id']);
    }

    /**
     * return count of new messages for this user
     *
     * @return int
     */
    public static function getCountOfNewMessage()
    {
        return intval(self::find()
            ->where([
                'recipient_id' => Yii::$app->user->id,
                'status' => Message::STATUS_NEW,
            ])
            ->count());
    }
}
