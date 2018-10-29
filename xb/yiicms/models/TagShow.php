<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the model class for table "ww_tag_show".
 *
 * @property string $id
 * @property string $tag_app_key
 * @property integer $tag_region_id
 * @property integer $tag_list_id
 * @property integer $sort
 * @property integer $status
 * @property integer $is_empty
 * @property integer $updated_at
 * @property integer $created_at
 */
class TagShow extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $tag_list_pid;
    static public  $app=[
        'ww'=>'问问',
      ];
    static public  $region=[
        '1'=>'中国',
      ];
    public static function tableName()
    {
        return 'ww_tag_show';
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
            [['tag_region_id', 'tag_list_id', 'sort', 'status', 'is_empty', 'updated_at', 'created_at'], 'integer'],
            [['tag_list_id'], 'required'],
            [['tag_app_key'], 'string', 'max' => 32],
            [['tag_list_pid'], 'safe'],
            ['tag_list_id', //只有 name 能接收错误提示，数组['name','shop_id']的场合，都接收错误提示
             'unique', 'targetAttribute'=>['tag_region_id','tag_app_key','tag_list_id'] ,            
             'comboNotUnique' => '标签已经在该app的区域中使用' //错误信息
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag_app_key' => 'app标识',
            'tag_region_id' => '归属区域',
            'tag_list_id' => '标签名称',
            'tag_list_pid' => '父标签',
            'sort' => '排序',
            'status' => '状态',
            'is_empty' => '该标签是否有用户',
            'updated_at' => '更新时间',
            'created_at' => '添加时间',
        ];
    }

    public static function getAppName($appkey="")
    {
      if ($appkey=="") {
        return self::$app;
      }
      
      if (array_key_exists($appkey,self::$app)) {
        return  self::$app[$appkey]; 
      }else{
        return "";
      }
      
    }

     public static function getRegionName($region_id="")
    {
      if ($region_id=="") {
        return self::$region;
      }
      
      if (array_key_exists($region_id,self::$region)) {
        return  self::$region[$region_id]; 
      }else{
        return "";
      }
      
    }

    public function getTagInfo()
    {
       return $this->hasOne(TagList::className(), [ 'id'=>'tag_list_id']);
    }

    /*
    *获取一级tag
    */
    public static function getTag0()
    {
      $list = TagList::find()
              ->where(['pid'=>0,'status'=>1])
              ->select('id,name')
              ->asArray()
              ->all();

      $res = \yii\helpers\ArrayHelper::map($list, 'id', 'name');
      $res [""]='全部';
      ksort($res);
      return $res ;
    }

    /**
     * @return maxed sort
     * @description 取mysql Lastsid
     */
    public static function getMaxSort(){
        $connection = self::getDb();
        $res = $connection->createCommand('select max(sort)+1 as max from ww_tag_show where status =1')->queryOne();
        if (empty($res['max'])) {
          return['max'=>0];
        }else {
          return $res;
        }
    }


}
