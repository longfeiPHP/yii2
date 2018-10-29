<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ww_users".
 *
 * @property string $id
 * @property string $uid
 * @property string $sid
 * @property string $gender
 * @property string $mobile
 * @property string $nickname
 * @property string $avatar
 * @property integer $verified
 * @property string $verified_reason
 * @property string $third_type
 * @property string $third_account
 * @property string $union_id
 * @property string $mopen_id
 * @property string $province
 * @property string $city
 * @property string $district
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ww_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['verified', 'status', 'created_at', 'updated_at'], 'integer'],
            [['uid', 'sid'], 'string', 'max' => 32],
            [['gender'], 'string', 'max' => 1],
            [['mobile', 'nickname', 'city', 'district'], 'string', 'max' => 16],
            [['avatar'], 'string', 'max' => 255],
            [['verified_reason'], 'string', 'max' => 64],
            [['third_type'], 'string', 'max' => 12],
            [['third_account', 'union_id', 'mopen_id'], 'string', 'max' => 128],
            [['province'], 'string', 'max' => 8],
            [['uid'], 'unique'],
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
            'gender' => 'Gender',
            'mobile' => 'Mobile',
            'nickname' => 'Nickname',
            'avatar' => 'Avatar',
            'verified' => 'Verified',
            'verified_reason' => 'Verified Reason',
            'third_type' => 'Third Type',
            'third_account' => 'Third Account',
            'union_id' => 'Union ID',
            'mopen_id' => 'Mopen ID',
            'province' => 'Province',
            'city' => 'City',
            'district' => 'District',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
