<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the model class for table "ww_tag_region".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $status
 * @property integer $updated_at
 * @property integer $created_at
 */
class TagRegion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ww_tag_region';
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
            [['name'], 'required'],
            [['status', 'updated_at', 'created_at'], 'integer'],
            [['name', 'code'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '区域名称',
            'code' => '区域CODE',
            'status' => '状态',
            'updated_at' => '更新时间',
            'created_at' => '创建时间',
        ];
    }
}
