<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ww_banner".
 *
 * @property integer $id
 * @property string $sid
 * @property string $img
 * @property string $h5_url
 * @property integer $jump_type
 * @property integer $banner_type
 * @property integer $banner_push
 * @property integer $banner_sort
 * @property integer $show_start_time
 * @property integer $show_end_time
 * @property integer $live_start_time
 * @property integer $live_end_time
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Banner extends \yii\db\ActiveRecord
{
    
    public $imageFile;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ww_banner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        //,'live_start_time','live_end_time'
        return [
            [['jump_type', 'banner_type', 'banner_push', 'banner_sort', 'status', 'created_at', 'updated_at'], 'integer'],
            [['sid'], 'string', 'max' => 32],
            [[ 'h5_url','img'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 100],
            [['title','show_start_time','show_end_time'],'required','message'=>'不能为空'], 
            [['jump_type'],'required','message'=>'选择跳转方式'], 
            [['imageFile'], 'file', 'extensions' => 'gif, jpg, png, jpeg','mimeTypes' => 'image/jpeg, image/png',],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sid' => '医生ID',
            'img' => 'banner图',
            'h5_url' => '链接',
            'title' => '活动标题',
            'jump_type' => '跳转方式',
            'banner_type' => '广告微信',
            'banner_push' => '弹出通知',
            'banner_sort' => '排序',
            'show_start_time' => '展示开始',
            'show_end_time' => '展示结束',
            'live_start_time' => '活动开始',
            'live_end_time' => '活动结束',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'imageFile'=>'banner图',
        ];
    }
}
