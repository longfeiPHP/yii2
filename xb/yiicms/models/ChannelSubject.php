<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;

use Yii;

/**
 * This is the model class for table "ww_channel_subject".
 *
 * @property integer $id
 * @property string $channel_key
 * @property string $channel_title
 * @property string $active_title
 * @property integer $show_start_time
 * @property integer $show_end_time
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class ChannelSubject extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ww_channel_subject';
    }

    public function behaviors()
    {

     return [
          [
              'class' => TimestampBehavior::className(),
              'attributes' => [
                    # 创建之前
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    # 修改之前
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at']
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
            [[ 'status', 'created_at', 'updated_at'], 'integer'],
            [['channel_key'], 'string', 'max' => 16],
            [['channel_title', 'active_title'], 'string', 'max' => 100],
            [['channel_title', 'active_title','show_start_time', 'show_end_time','channel_key'],'required','message'=>'不能为空'],
            [['channel_key'], 'unique'],
            [['show_start_time', 'show_end_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'channel_key' => '频道Key',
            'channel_title' => '默认标题',
            'active_title' => '活动标题',
            'show_start_time' => '开始时间',
            'show_end_time' => '结束时间',
            'status' => '状态',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
