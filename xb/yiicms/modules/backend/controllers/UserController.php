<?php

namespace app\modules\backend\controllers;

use Yii;
use app\models\Users;
use app\modules\backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\RedisKey;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $params=Yii::$app->request->queryParams;

        if (empty($params)) {
            $params['UserSearch']['verified']=1;
        }
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionUsercode()
    {
        \Yii::$app->redis->SETEX(RedisKey::userCodeValueKey('13718188583'),8974,'876544');
        return $this->render('usercode');
    }

    public function actionSearchCode()
    {
       Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        $mobile=\Yii::$app->request->post('mobile','');
        if (empty($mobile)) {
             return ['code'=>0,'error'=>'手机号不能为空'];
        }
        $redis = \Yii::$app->redis;
        // $redis->SETEX(RedisKey::userCodeValueKey($mobile),'876544',8974);
        $expire = $redis->TTL(RedisKey::userCodeValueKey($mobile));

        if ($expire > 0) {
            $value = $redis->get(RedisKey::userCodeValueKey($mobile));
            return ['code'=>1,'error'=>'','data'=>['expire'=>$expire,'value'=>$value]];
        }
        return ['code'=>0,'error'=>'不存在验证码'];

    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // public function actionCreate()
    // {
    //     $model = new User();

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     } else {
    //         return $this->render('create', [
    //             'model' => $model,
    //         ]);
    //     }
    // }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     } else {
    //         return $this->render('update', [
    //             'model' => $model,
    //         ]);
    //     }
    // }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(['index']);
    // }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
