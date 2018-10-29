<?php

namespace app\modules\backend\controllers;

use Yii;
use app\models\UsersInfo;
use app\modules\backend\models\UsersInfoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\VerifiedHistory;
use app\models\Users;

/**
 * UsersInfoController implements the CRUD actions for UsersInfo model.
 */
class UsersInfoController extends Controller
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
     * Lists all UsersInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsersInfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // var_dump($dataProvider);return;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UsersInfo model.
     * @param string $id
     * @return mixed
     */
    // public function actionView($id)
    // {
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }

    /**
     * Creates a new UsersInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // public function actionCreate()
    // {
    //     $model = new UsersInfo();

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     } else {
    //         return $this->render('create', [
    //             'model' => $model,
    //         ]);
    //     }
    // }

    /**
     * Updates an existing UsersInfo model.
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
     * Deletes an existing UsersInfo model.
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
     * 审核功能.
     * @param string $id
     * @return mixed
     */
    public function actionVerify()
    {
        Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        $id=\Yii::$app->request->post('id','');
        $action=\Yii::$app->request->post('action','');
        $reason=\Yii::$app->request->post('reason','');
        $actions=['verify','reject'];
        if (empty($id)||empty($action)||empty($reason) || !in_array($action,$actions)) {
            echo(json_encode(['code'=>0,'error'=>'参数错误！']));
            return;
        }
        $model1 = $this->findModel($id);
        
        if (empty($model1)) {
            echo(json_encode(['code'=>0,'error'=>'记录不存在！']));
            return;
        }
        if ($action=='verify') {
           $status=1;
        }else{
           $status=2;
        }

        $model1->id_status=$status;
        $Users = Users::findOne(['uid'=>$model1->uid]);

        if (empty($Users)) {
            echo(json_encode(['code'=>0,'error'=>'用户不存在！']));
            return;
        }
        
        $Users->verified = $status;
        $Users->verified_reason = $reason;
        $Users->save();
        $vh = new VerifiedHistory;
        $vh->uid =$model1->uid;
        $vh->sid =$model1->sid;
        $vh->verified = $status;
        $vh->uname = isset(Yii::$app->user->identity->username) ? Yii::$app->user->identity->username:'';
        $vh->verified_reason =$reason;
        $vh->created_at=time();        
        $model1->save();
        $vh->save();
        echo(json_encode(['code'=>1,'error'=>'成功']));
        return;

    }

    /**
     * 审核历史功能.
     * @param string $uid
     * @return mixed
     */
    public function actionVerifyHis()
    {
        Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        $uid=\Yii::$app->request->post('uid','');

        if (empty($uid)) {
            return ['code'=>0,'error'=>'参数错误！','data'=>[]];

        }
        $model=VerifiedHistory::find()->where(['uid'=>$uid])->all();
        // $model=VerifiedHistory::findOne(['uid'=>$uid]);
        // var_dump(\yii\helpers\Json::encode($model));return;
        return ['code'=>1,'error'=>'成功','data'=>$model];
    }

    /**
     * Finds the UsersInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return UsersInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UsersInfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
