<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_like".
 *
 * @property integer $id
 * @property string $login
 * @property integer $status
 */
class UserLike extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'repo_like_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['login'], 'required'],
            [['status'], 'integer'],
            [['login'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'status' => 'Status',
        ];
    }
}
