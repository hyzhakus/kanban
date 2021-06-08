<?php

namespace app\models;

use Yii;
use app\models\User;

/**
 * This is the model class for table "{{%tasks}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $created_at
 * @property string $name
 * @property string $note
 * @property int $desk_id
 *
 * @property Users $user
 * @property Desk $desk
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tasks}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'desk_id'], 'required'],
            [['user_id', 'desk_id'], 'integer'],
            [['note'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['desk_id'], 'unique', 'targetAttribute' => ['id', 'desk_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['desk_id'], 'exist', 'skipOnError' => true, 'targetClass' => Desk::className(), 'targetAttribute' => ['desk_id' => 'id']],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User'),
            'created_at' => Yii::t('app', 'Created At'),
            'name' => Yii::t('app', 'Name'),
            'note' => Yii::t('app', 'Note'),
            'desk_id' => Yii::t('app', 'Desk'),
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Desk]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDesk()
    {
        return $this->hasOne(Desk::className(), ['id' => 'desk_id']);
    }
}
