<?php
/**
 * Created by PhpStorm.
 * User: david
 */

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\Expression;
use Yii;
use app\components\behaviors\UploadBehavior;
class News extends Content
{
    static $currentType = Parent::TYPE_NEWS;
    public $imageFile;
    public function rules()
    {
        return [
            [['title', 'type', 'status','category_id'], 'required'],
            [['imageFile'], 'file', 'extensions' => 'gif, jpg, png, jpeg','mimeTypes' => 'image/jpeg, image/png',],
            [['type', 'status', 'admin_user_id', 'category_id','created_at', 'updated_at'], 'integer'],
            [['title', 'image', 'description','keywords'], 'string', 'max' => 255],
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
            $this->image = $file;
        }
        return true;
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
}