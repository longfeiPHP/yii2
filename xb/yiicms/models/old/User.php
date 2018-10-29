<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "xdj_users".
 *
 * @property string $id
 * @property string $uid
 * @property string $sid
 * @property string $mobile
 * @property string $third_type
 * @property string $third_account
 * @property string $unionid
 * @property string $mpopenid
 * @property string $nickname
 * @property string $realname
 * @property string $gender
 * @property integer $level
 * @property integer $star_level
 * @property string $birthday
 * @property string $blood_type
 * @property string $interest
 * @property string $job
 * @property string $id_card_type
 * @property string $id_card_no
 * @property string $id_card_image
 * @property string $organization_id
 * @property string $nanny_id
 * @property string $avatar
 * @property string $slogan
 * @property integer $id_status
 * @property integer $verified
 * @property string $verified_reason
 * @property string $province
 * @property string $city
 * @property string $district
 * @property string $new_pop_url
 * @property integer $is_share_sm
 * @property integer $s_status
 * @property integer $is_fill_information
 * @property integer $is_zombie
 * @property string $wechat_info
 * @property integer $shut_up_count
 * @property integer $weight
 * @property integer $temp
 * @property integer $is_star
 * @property integer $is_activity
 * @property integer $state
 * @property integer $created
 * @property integer $updated
 * @property integer $online_state
 * @property integer $is_fraud
 * @property integer $s_type
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'xdj_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['level', 'star_level', 'id_status', 'verified', 'is_share_sm', 's_status', 'is_fill_information', 'is_zombie', 'shut_up_count', 'weight', 'temp', 'is_star', 'is_activity', 'state', 'created', 'updated', 'online_state', 'is_fraud', 's_type'], 'integer'],
            [['birthday'], 'safe'],
            [['uid', 'sid', 'id_card_type', 'id_card_no', 'organization_id', 'nanny_id'], 'string', 'max' => 32],
            [['mobile', 'nickname', 'realname', 'job', 'city', 'district'], 'string', 'max' => 16],
            [['third_type'], 'string', 'max' => 12],
            [['third_account', 'unionid', 'mpopenid', 'id_card_image', 'new_pop_url'], 'string', 'max' => 128],
            [['gender'], 'string', 'max' => 1],
            [['blood_type'], 'string', 'max' => 6],
            [['interest', 'slogan', 'verified_reason'], 'string', 'max' => 64],
            [['avatar'], 'string', 'max' => 255],
            [['province'], 'string', 'max' => 8],
            [['wechat_info'], 'string', 'max' => 1000],
            [['uid'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'uid' => 'Uid',
            'sid' => 'Sid',
            'mobile' => '手机',
            'third_type' => 'Third Type',
            'third_account' => 'Third Account',
            'unionid' => 'Unionid',
            'mpopenid' => 'Mpopenid',
            'nickname' => '昵称',
            'realname' => '真实姓名',
            'gender' => '性别',
            'level' => '级别',
            'star_level' => '主播级别',
            'birthday' => '生日',
            'blood_type' => 'Blood Type',
            'interest' => 'Interest',
            'job' => 'Job',
            'id_card_type' => 'Id Card Type',
            'id_card_no' => 'Id Card No',
            'id_card_image' => 'Id Card Image',
            'organization_id' => 'Organization ID',
            'nanny_id' => 'Nanny ID',
            'avatar' => 'Avatar',
            'slogan' => 'Slogan',
            'id_status' => 'Id Status',
            'verified' => 'Verified',
            'verified_reason' => 'Verified Reason',
            'province' => 'Province',
            'city' => 'City',
            'district' => 'District',
            'new_pop_url' => 'New Pop Url',
            'is_share_sm' => 'Is Share Sm',
            's_status' => 'S Status',
            'is_fill_information' => 'Is Fill Information',
            'is_zombie' => 'Is Zombie',
            'wechat_info' => 'Wechat Info',
            'shut_up_count' => 'Shut Up Count',
            'weight' => 'Weight',
            'temp' => 'Temp',
            'is_star' => 'Is Star',
            'is_activity' => 'Is Activity',
            'state' => 'State',
            'created' => 'Created',
            'updated' => 'Updated',
            'online_state' => 'Online State',
            'is_fraud' => 'Is Fraud',
            's_type' => 'S Type',
        ];
    }
}
