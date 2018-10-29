<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ww_verified_history".
 *
 * @property string $id
 * @property string $uid
 * @property string $sid
 * @property integer $verified
 * @property string $uname
 * @property string $verified_reason
 * @property integer $created_at
 */
class VerifiedHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ww_verified_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['verified', 'created_at'], 'integer'],
            [['uid', 'sid', 'uname'], 'string', 'max' => 32],
            [['verified_reason'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'sid' => 'Sid',
            'verified' => 'Verified',
            'uname' => 'Uname',
            'verified_reason' => 'Verified Reason',
            'created_at' => 'Created At',
        ];
    }
}
