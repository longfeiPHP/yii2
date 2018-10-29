<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;
use Yii;
use app\components\behaviors\UploadBehavior;
/**
 * This is the model class for table "ww_share_info".
 *
 * @property string $id
 * @property integer $event
 * @property string $platform
 * @property string $title
 * @property string $summary
 * @property string $img_url
 * @property string $target_url
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class ShareInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ww_share_info';
    }

    static public  $platForm=[
        'qq'=>'QQ',
        'qqZone'=>'QQ空间',
        'weChat'=>'微信',
        'moments'=>'朋友圈',
        'Weibo'=>'微博',

      ];

    static public  $eventList=[
        '1'=>'app分享',
        '2'=>'邀请分享',

      ];

    static public  $statusList=[
        '0'=>'无效',
        '1'=>'有效',

      ];

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
          [
              'class'=>UploadBehavior::className(),
              'saveDir'=>'products-img/'
          ]
      ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event', 'status', 'created_at', 'updated_at'], 'integer'],
            [['platform'], 'string', 'max' => 16],
            [['title'], 'string', 'max' => 128],
            [['summary'], 'string', 'max' => 512],
            [['img_url', 'target_url'], 'string', 'max' => 255],
            [['title', 'summary','event','platform', 'target_url'], 'required'],
            ['imageFile', 'requiredByInsert','params'=>['message' =>'不是等于mrs' ], 'skipOnEmpty' => false, 'skipOnError' => false],
            
            [[ 'target_url'], 'url', 'defaultScheme' => 'http'],
            ['platform', //只有 name 能接收错误提示，数组['name','shop_id']的场合，都接收错误提示
             'unique', 'targetAttribute'=>['platform','event'] ,            
             'comboNotUnique' => '此平台已经设置了该事件的分享' //错误信息
            ],
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
            'event' => '事件',
            'platform' => '分享平台',
            'title' => '分享标题',
            'summary' => '分享描述',
            'img_url' => '分享图',
            'imageFile' => '分享图',
            'target_url' => '分享URL',
            'status' => '状态',
            'created_at' => '添加时间',
            'updated_at' => '更新时间',
        ];
    }

    public function beforeSave($insert)
    {
        $res = parent::beforeSave($insert);
        if($res==false){
            return $res;
        }
        if (!$this->validate()) {
            Yii::info('Model not updated due to validation error.', __METHOD__);
            return false;
        }
        $file = $this->uploadImgFile();
        if($file){
            $this->img_url = $file;
        }
        return true;
    }

    public static function getPlatName($plat="")
    {
      if ($plat=="") {
        return self::$platForm;
      }
      
      if (array_key_exists($plat,self::$platForm)) {
        return  self::$platForm[$plat]; 
      }else{
        return "";
      }
      
    }

    public static function getEventName($event="")
    {
      if ($event=="") {
        return self::$eventList;
      }
      
      if (array_key_exists($event,self::$eventList)) {
        return  self::$eventList[$event]; 
      }else{
        return "";
      }
      
    }

    public static function getStatus($status="")
    {
      if ($status==="") {
        return self::$statusList;
      }
      
      if (array_key_exists((string)$status,self::$statusList)) {
        return  self::$statusList[(string)$status]; 
      }else{
        return "null";
      }
      
    }

  public function requiredByInsert($attribute, $params)
  {
    
    if($this->$attribute==""  && $this->isNewRecord)
    {
      $this->addError($attribute, "分享图不可以为空.");
    }
  }

}
