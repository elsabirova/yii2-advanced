<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "chat".
 *
 * @property int $id
 * @property string $message
 * @property int $author_id
 * @property int $created_at
 *
 * @property User $author
 */
class Chat extends \yii\db\ActiveRecord
{
    const RELATION_AUTHOR = 'author';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message', 'author_id', 'created_at'], 'required'],
            [['message'], 'string'],
            [['author_id', 'created_at'], 'integer'],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message' => 'Message',
            'author_id' => 'Author ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ChatQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ChatQuery(get_called_class());
    }
}
