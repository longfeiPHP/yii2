<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property string $content
 * @property int $status
 * @property int $create_time
 * @property int $userid
 * @property string $email
 * @property string $url
 * @property int $post_id
 *
 * @property Post $post
 * @property Commentstatus $status0
 * @property User $user
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'status', 'userid', 'email', 'post_id'], 'required'],
            [['content'], 'string'],
            [['status', 'create_time', 'userid', 'post_id'], 'integer'],
            [['email', 'url'], 'string', 'max' => 128],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => Commentstatus::className(), 'targetAttribute' => ['status' => 'id']],
            [['userid'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        	'id' => 'ID',//ID
        	'content' => '内容',//Content
        	'status' => '状态',//Status
        	'create_time' => '发布时间',//Create Time
        	'userid' => '用户',//Userid
        	'email' => 'Email',//Email
        	'url' => 'Url',//Url
        	'post_id' => '文章',//Post ID
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(Commentstatus::className(), ['id' => 'status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userid']);
    }
    
    
    public function getBeginning()
    {
    	$tmpStr = strip_tags($this->content);
    	$tmpLen = mb_strlen($tmpStr);
    	return mb_substr($tmpStr, 0, 20, 'utf-8').(($tmpLen>20)?'...':'');
    }
    public function approve()
    {
    	$this->status = 2;
    	return ($this->save()?true:false);
    }
    public static function getPengdingCommentCount()
    {
    	return Comment::find()->where(['status'=>1])->count();
    }
    public function beforeSave($insert){
    	if (parent::beforeSave($insert))
    	{
    		if ($insert)
    		{
    			$this->create_time = time();
    		}
    		return true;
    	}
    	else 
    	{
    		return false;
    	}
    }
    public static function findRecentComments($limit=10)
    {
    	return Comment::find()->where(['status'=>2])->orderBy('create_time DESC')
    	->limit($limit)->all();
    }
}
