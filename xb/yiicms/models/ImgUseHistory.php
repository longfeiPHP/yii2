<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "ww_img_use_history".
 *
 * @property string $id
 * @property string $image
 * @property integer $status
 * @property integer $created_at
 */
class ImgUseHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ww_img_use_history';
    }

    public function behaviors()
    {

     return [
          [
              'class' => TimestampBehavior::className(),
              'createdAtAttribute' => 'created_at',// 自己根据数据库字段修改
              'updatedAtAttribute' => 'updated_at', // 自己根据数据库字段修改
              'value' => time(), // 自己根据数据库字段修改
          ],
      ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'created_at'], 'integer'],
            [['image'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Image',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'updated At',
            
        ];
    }

    public static function newData($img='',$status=0)
    {
        $model =new self;
        $model->image =$img;
        $model->status =$status;
        return $model->save();
    }

    public static function UpdateData($img='',$status=0)
    {
        $model =static::findOne(['image'=>$img]);
        $model->status =$status;
        return $model->save();
    }

}
