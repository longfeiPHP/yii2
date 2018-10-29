<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ww_users_info".
 *
 * @property string $id
 * @property string $uid
 * @property string $sid
 * @property string $mobile
 * @property string $realname
 * @property integer $stype
 * @property integer $id_status
 * @property string $id_card_type
 * @property string $id_card_no
 * @property string $id_card_img
 * @property string $id_card_bg_img
 * @property string $id_card_usr_img
 * @property string $real_card_img
 * @property integer $hospitial_id
 * @property integer $department_id
 * @property integer $jobtitle_id
 * @property string $reg_cert_img
 * @property string $job_title_img
 * @property integer $priority
 * @property integer $created_at
 * @property integer $updated_at
 */
class UsersInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ww_users_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['stype', 'id_status', 'hospital_id', 'department_id', 'jobtitle_id', 'priority', 'created_at', 'updated_at'], 'integer'],
            [['uid', 'sid', 'id_card_type', 'id_card_no'], 'string', 'max' => 32],
            [['mobile', 'realname'], 'string', 'max' => 16],
            [['id_card_img', 'id_card_bg_img', 'id_card_usr_img', 'real_card_img', 'reg_cert_img', 'job_title_img'], 'string', 'max' => 255],
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
            'uid' => '用户ID',
            'sid' => '医生ID',
            'mobile' => '手机号',
            'realname' => '姓名',
            'stype' => '类别',
            'id_status' => '状态',
            'id_card_type' => '身份类别',
            'id_card_no' => '身份证号',
            'id_card_img' => '身份证图',
            'id_card_bg_img' => '身份证背面图',
            'id_card_usr_img' => '持证照',
            'real_card_img' => 'Real Card Img',
            'hospital_id' => 'Hospital ID',
            'department_id' => 'Department ID',
            'jobtitle_id' => 'Jobtitle ID',
            'reg_cert_img' => '资格证图',
            'job_title_img' => '职称图',
            'priority' => '优先级',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHospital()
    {
        return $this->hasOne(Hospitial::className(), [ 'id'=>'hospital_id' ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobtitle()
    {
        return $this->hasOne(Jobtitle::className(), ['id'=>'jobtitle_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::className(), [ 'id'=>'department_id']);
    }
}
