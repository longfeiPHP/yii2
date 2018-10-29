<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $id
 * @property string $username
 * @property string $password_hash
 */
class User extends \app\core\front\FrontActiveRecord implements \yii\web\IdentityInterface
{
	public $id;
	public $username;
	public $password_hash;
	public $rememberMe;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password_hash'], 'required'],
            [['username'], 'string', 'max' => 50],
            [['password_hash'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password_hash' => 'Password Hash',
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
//     	return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
    	foreach (self::$users as $user) {
    		if ($user['accessToken'] === $token) {
    			return new static($user);
    		}
    	}
    	
    	return null;
    }
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
    	foreach (self::$users as $user) {
    		if (strcasecmp($user['username'], $username) === 0) {
    			return new static($user);
    		}
    	}
    	
    	return null;
    }
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
    	return $this->id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
    	return $this->authKey;
    }
    
    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
    	return $this->authKey === $authKey;
    }
    
    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
    	return $this->password_hash === $password;
    }
    /**
     * 登录
     */
    public function login()
    {
    	if (!$this->validate()){
    		$err = $this->getErrors();
    		return false;
    	}
    	$user = User::findOne(['username'=>$this->username]);//通过用户输入的用户名从表中选出数据  
    	if ($user !== null){
    		if ($this->validatePassword($this->password_hash,$user->password_hash)){
    			Yii::$app->user->login($user,$this->rememberMe ? 3600*24*30 : 0);
    			return true;
    		}
    		return false;
    	}else {
    		return false;
    	}
    }
}
