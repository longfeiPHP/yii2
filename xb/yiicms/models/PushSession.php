<?php

namespace app\models;

use Yii;
use app\components\behaviors\UploadBehavior;
/**
 * This is the model class for table "ww_push_session".
 *
 * @property string $id
 * @property string $type
 * @property string $ww_id
 * @property string $nickname
 * @property string $avatar
 * @property integer $verified
 * @property integer $status
 */
class PushSession extends  \yii\db\ActiveRecord
{
    
    static public $StatusArr =[
        '0'=>'无效',
        '1'=>'有效',
    ];

    static public $VerifyArr =[
        '0'=>'未认证',
        '1'=>'已认证',
    ];

    public $imageFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ww_push_session';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['verified', 'status'], 'integer'],
            [['type', 'nickname'], 'string', 'max' => 16],
            [[ 'avatar'], 'string', 'max' => 255],
            [['ww_id'], 'string', 'max' => 24],
            [['type','ww_id'], 'unique'],
            [['type','nickname',],'required'],
            [['imageFile'], 'file', 'extensions' => 'gif, jpg, png, jpeg','mimeTypes' => 'image/jpeg, image/png',],
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
            $this->avatar = $file;
        }
        if($this->isNewRecord)
        {
          $this->ww_id=$this->genUid(8);
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '类型标志',
            'ww_id' => '系统账户id',
            'nickname' => '类型名称',
            'avatar' => 'LOGO',
            'imageFile' => 'LOGO',
            'verified' => '认证状态',
            'status' => '状态',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class'=>UploadBehavior::className(),
                'saveDir'=>'products-img/'
            ]
        ];
    }

    function genUid($len)
    {
        $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
        $string=time();
        for(;$len>=1;$len--)
        {
            $position=rand()%strlen($chars);
            $position2=rand()%strlen($string);
            $string=substr_replace($string,substr($chars,$position,1),$position2,0);
        }
        return $string;
    }
}
