<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the model class for table "ww_tag_list".
 *
 * @property string $id
 * @property integer $pid
 * @property string $key
 * @property string $name
 * @property string $title
 * @property integer $status
 * @property integer $updated_at
 * @property integer $created_at
 */
class TagList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    const STATUS_ABLE =1;
    const STATUS_DISABLED =1;
    public static function tableName()
    {
        return 'ww_tag_list';
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
            [['pid', 'status', 'updated_at', 'created_at'], 'integer'],
            [['key', 'name', 'title'], 'required'],
            [['key', 'name'], 'string', 'max' => 32],
            [['title'], 'string', 'max' => 64],
            [['key'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => '父标签',
            'key' => '标签号',
            'name' => '标签名称',
            'title' => '标签主题',
            'status' => '状态',
            'updated_at' => '更新时间',
            'created_at' => '创建时间',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPidName()
    {
        return $this->hasOne(TagList::className(), [ 'id'=>'pid']);
    }

    /*
    *返回所有根标签
    */
    public static function PNameList()
    {
        $pNameList =  TagList::find()
            ->select('id,name')
            ->where(['pid'=>0,'status'=>TagList::STATUS_ABLE])
            ->asArray()
            ->all();
        
        $result= \yii\helpers\ArrayHelper::map($pNameList, 'id', 'name');
        $result[0] ='顶级标签';
        ksort($result);
        return $result ;
    }

    /*
    *返回所有标签，并按照根标签组合
    */
    public static function AllGroupList()
    {
        $pNameList =  TagList::find()
            ->select('id,name,pid')
            ->where(['status'=>TagList::STATUS_ABLE])
            ->asArray()
            ->all();
 
        $result = \yii\helpers\ArrayHelper::index($pNameList, null, 'pid');
        foreach ($result as $key => $value) {
            $result[$key]=\yii\helpers\ArrayHelper::map($value, 'id', 'name');
        }

        return $result ;
    }


}
