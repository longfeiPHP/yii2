<?php
namespace app\modules\models;

use Yii;
use yii\data\Pagination;
use app\modules\models\OperationLog;

class User extends \app\models\User
{
    /**
     * 通过条件获得用户全部信息
     */ 
    public static function userList()
    {
        $request = \yii::$app->request;
        $arrGet = $request->get();
        // 拼接数组
        $arrWhere = [];
        if(!empty($arrGet['nickname'])) {$arrWhere['nickname']= new \MongoRegex("/".$arrGet['nickname']."/i");}
        if(!empty($arrGet['mobile']))      {$arrWhere['mobile']  =$arrGet['mobile'];}

        $arrWhere['page_size'] = isset($arrGet['page_size'])?(int)$arrGet['page_size']:10;
        $arrWhere['page'] = empty($arrGet['page']) ?0:(int)$arrGet['page'] ;

        $arrUser = User::getUserAllInfoByWhere($arrWhere);

        return ['count'=>$arrUser['count'],'pages'=>$arrUser['page'],'data'=>$arrUser['data']];
    }

    /**
     * 通过条件获得用户全部信息
     */ 
    public static function getUserAllInfoByWhere($params = [])
    {
        $pageSize = isset($params['page_size'])?(int)$params['page_size']:10;
        $page     = isset($params['page'])?(int)$params['page']:0;
        unset($params['page_size']);
        unset($params['page']);

        $query = User::find()->where($params);
        $countQuery = clone $query;
        $pages = new Pagination(['pageSizeParam'=>'page_size','totalCount' => $countQuery->count()]);

        $intCount = $query->count();
        $arrSales = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy('created_at desc')
            ->all();

        return ['count'=>$intCount,'data'=>$arrSales,'page'=>$pages];
    }

    /**
     * 更改用户状态
     */ 
    public static function updateUserState()
    {
        $content = '原因不明';
        $from = '';
        $to = '';
        $request = \yii::$app->request;
        $arrGet = $request->get();
        //添加后台操作日志
        if(!empty($arrGet['content'])){
            $content = $arrGet['content'];
        }
        if(empty($arrGet['id']))
        {
            return false;
        }
        $state = ($arrGet['state']==0)?-1:0;
        if($arrGet['state'] == 0){
            $from = '正常登录';
            $to = '禁止登录';
        }
        if($arrGet['state'] == -1){
            $from = '禁止登录';
            $to = '正常登录';
        }
        OperationLog::log(OperationLog::TYPE_User, $content, $arrGet['id'], '', ['用户状态更改'], [['from'=>$from, 'to'=>$to]]);
        $strMongoId = $arrGet['id'];
        try {
            $id = new \MongoId($strMongoId);
        } catch (\MongoException $ex) {
            $id = new \MongoId();
        }
        $obUser = User::findOne(['_id' => $id]);
        if($state < 0){
           static::logout($id);
        }
        $obUser->state = (int)$state;
        return $obUser->update(false, ['state', 'access_token']);
    }

    /**
     * 通过ID获得用户全部信息
     */ 
    public static function getUsersAllInfoByIdKey($params = [])
    {
        $obUser = User::find()->where($params)->asArray()->all();
        $arrData = [];
        foreach($obUser as $key => $value)
        {
            $id = (string)$value['_id'];
            $arrData[$id] = $value;
        }
        return $arrData;
    }

    /**
     * 获取用户id号
     */
    public static function getUserId($phone)
    {
        if(empty($phone)){
            return '';
        }
        /*$user = User::findOne(['mobile' => $phone]);
        if(!isset($user -> _id)){
            return '';
        }
        return (string)$user -> _id;*/
        $user = \app\models\v4\User::findOne(['mobile' => $phone]);
        if(!isset($user -> uid)){
            return '';
        }
        return $user -> uid;

    }


}