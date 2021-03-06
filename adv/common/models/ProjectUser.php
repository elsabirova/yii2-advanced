<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "project_user".
 *
 * @property int $id
 * @property int $project_id
 * @property int $user_id
 * @property string $role
 *
 * @property Project $project
 * @property User $user
 */
class ProjectUser extends \yii\db\ActiveRecord
{
    const ROLE_DEVELOPER    = 'developer';
    const ROLE_MANAGER      = 'manager';
    const ROLE_TESTER       = 'tester';

    const ROLES = [
        self::ROLE_DEVELOPER,
        self::ROLE_MANAGER,
        self::ROLE_TESTER,
    ];
    const ROLE_LABELS = [
        self::ROLE_DEVELOPER    => 'Developer',
        self::ROLE_MANAGER      => 'Manager',
        self::ROLE_TESTER       => 'Tester',
    ];

    const RELATION_PROJECT  = 'project';
    const RELATION_USER  = 'user';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'user_id'], 'required'],
            [['project_id', 'user_id'], 'integer'],
            ['role', 'in', 'range' => self::ROLES],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user.username' => 'Name',
            'user.email' => 'Email',
            'user.created_at' => 'Created at',
            'user.updated_at' => 'Updated at',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::class, ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ProjectUserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProjectUserQuery(get_called_class());
    }
}
