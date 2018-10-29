<?php
/**
 * User: stanleylfc
 * Date: 15-6-17 下午2:47
 * Description:
 */
namespace app\components;
use Yii;

\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
class ApiController extends  \yii\web\Controller
{
    // $response = Yii::$app->response;
    
    public $enableCsrfValidation = false;
    public function getAuth($token,$userID = 0)
    {
        
    }

    /**
     * 去掉mongo 版本的权限认证
     * @param string $uid 用户的uid
     * @param string $token 用户的token
     * @param boolean $flag 返回数据标志，true 返回用户数组，false 返回用户uid
     * @return string|array|mixed
     * @author stanleylfc
     */
    public function getUserAuth($uid = '', $token = '', $flag = false )
    {
        
    }
}
