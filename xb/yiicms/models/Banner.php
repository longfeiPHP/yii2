<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

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

    /** banner */
    const TYPE_BANNER = 0;
    /** 推荐 */
    const TYPE_RECOMMEND =1;


    /** @var array  */
    static public $banner_type = [
        self::TYPE_BANNER=>'Banner',
        self::TYPE_RECOMMEND=>'推荐位',

    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ww_banner';
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
        //,'live_start_time','live_end_time'
        return [
            [['jump_type', 'banner_type', 'banner_push', 'banner_sort', 'status', 'created_at', 'updated_at'], 'integer'],
            [['sid'], 'string', 'max' => 32],
            [[ 'h5_url','img'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 100],
            [['title','show_start_time','show_end_time'],'required','message'=>'不能为空'], 
            [['jump_type'],'required','message'=>'选择跳转方式'], 
            [['imageFile'], 'file', 'extensions' => 'gif, jpg, png, jpeg','mimeTypes' => 'image/jpeg, image/png',],
            [['live_start_time','live_end_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sid' => '主播ID',
            'img' => '展示图',
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
            'imageFile'=>'展示图',
        ];
    }

    /**
     * @return maxed sort
     * @description 取mysql Lastsid
     */
    public static function getMaxSort(){
        $connection = self::getDb();
        $res = $connection->createCommand('select max(banner_sort)+1 as max from ww_banner where status =1')->queryOne();
        if (empty($res['max'])) {
          return['max'=>0];
        }else {
          return $res;
        }
    }


    /**
     * 分类类型
     * @return array
     */
    public static function getBannerType()
    {
        return self::$banner_type;
    }
}
