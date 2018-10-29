<?php

namespace app\models;

use Yii;
use app\models\PushSession;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "ww_push_message".
 *
 * @property string $id
 * @property string $type
 * @property string $notity_title
 * @property string $notity_content
 * @property string $im_content
 * @property integer $status
 * @property string $notity_result
 * @property integer $created_at
 * @property integer $updated_at
 */
class PushMessage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ww_push_message';
    }

     public function behaviors()
    {

     return [
          [
              'class' => TimestampBehavior::className(),
              'attributes' => [
                    # 创建之前
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    # 修改之前
                    // \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at']
                ],
                #设置默认值
                'value' => time(),
          ],
      ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['type'], 'string', 'max' => 16],
            [['notity_title'], 'string', 'max' => 128],
            [['notity_content', 'im_content'], 'string', 'max' => 512],
            [['notity_result'], 'string', 'max' => 255],
            [['notity_title','notity_content', 'im_content','type'], 'required'],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '推送帐号',
            'notity_title' => '通知标题',
            'notity_content' => '通知内容',
            'im_content' => '消息内容',
            'status' => '状态',
            'notity_result' => '推送结果',
            'created_at' => '添加时间',
            'updated_at' => '更新时间',
        ];
    }

    public function getAccountInfo()
    {
       return $this->hasOne(PushSession::className(), [ 'type'=>'type']);
    }

    /*
    *获取一级tag
    */
    public static function getAllAccount()
    {
      $list = PushSession::find()
              ->where(['status'=>1])
              ->select('type,nickname')
              ->asArray()
              ->all();

      return \yii\helpers\ArrayHelper::map($list, 'type', 'nickname');
    }
}
