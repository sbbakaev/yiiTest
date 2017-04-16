<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "repo_like_status".
 *
 * @property integer $id
 * @property string $repo_id
 * @property integer $status
 */
class RepoLikeStatus extends \yii\db\ActiveRecord
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
            [['repo_id'], 'required'],
            [['status'], 'integer'],
            [['repo_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'repo_id' => 'Repo ID',
            'status' => 'Status',
        ];
    }
}
