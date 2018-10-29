<?php

namespace app\modules\backend\controllers;

use Yii;
use app\models\PushMessage;
use app\modules\backend\models\PushMessageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\backend\components\Getui;

/**
 * PushMessageController implements the CRUD actions for PushMessage model.
 */
class PushMessageController extends Controller
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
     * Lists all PushMessage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PushMessageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PushMessage model.
     * @param string $id
     * @return mixed
     */
    public function actionView()
    {
        Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        $id=\Yii::$app->request->post('id','');
        if (empty($id)) {
            echo(json_encode(['code'=>1,'error'=>'参数错误！']));
            return;
        }
        $model =PushMessage::find()->where(['id'=>$id])->asArray()->one();
        
        if (empty($model)) {
            echo(json_encode(['code'=>1,'error'=>'记录不存在！']));
            return;
        }else{
            $model['typeList']=PushMessage::getAllAccount();
            echo(json_encode(['code'=>0,'error'=>'成功','data'=>$model]));
            return;
        }
    }

    /**
     * Displays a single PushMessage model.
     * @param string $id
     * @return mixed
     */
    public function actionSend()
    {
        Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        $id=\Yii::$app->request->post('id','');
        if (empty($id)) {
            echo(json_encode(['code'=>1,'error'=>'参数错误！']));
            return;
        }
        $model =PushMessage::find()->joinWith('accountInfo')->where(['ww_push_message.id'=>$id])->asArray()->one();
        // var_dump($model);return;
        if (empty($model)) {
            echo(json_encode(['code'=>1,'error'=>'记录不存在！']));
            return;
        }else{
            $notity_title=$model['notity_title'];
            $notity_content=$model['notity_content'];
            $im_content=$model['im_content'];
            $logo_url=$model['accountInfo']['avatar'];
            $GeTuiInit = new Getui();
            $res = $GeTuiInit->SendToApp($notity_title,$notity_content,$im_content,$logo_url);
            // echo(json_encode($res));
            // echo($res['result']);$res['contentId'];
            // json_encode(['code'=>0,'error'=>'成功','data'=>$res]);
            $modelSave = $this ->findModel($model['id']);
            if (!empty($res['result']) && $res['result']=='ok') {
                
                $modelSave->notity_result ='成功，发送Id：'.$res['contentId'];
                $modelSave->updated_at =time();
                $modelSave->save();
                echo(json_encode(['code'=>0,'error'=>'成功']));
            }else{

                $modelSave->notity_result ='失败，res：'.json_encode($res);
                $modelSave->updated_at =0;
                $modelSave->save();
                echo(json_encode(['code'=>1,'error'=>'发送失败！']));
            }
            
            return;
        }
    }

    /**
     * Creates a new PushMessage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PushMessage();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PushMessage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    {
        Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        $id=\Yii::$app->request->post('id','');

        $model = $this->findModel($id);
        if ($model) {
            $model->im_content =\Yii::$app->request->post('im_content','');
            $model->notity_content = \Yii::$app->request->post('notity_content','');
            $model->notity_title = \Yii::$app->request->post('notity_title','');
            $model->type = \Yii::$app->request->post('type','');
            $model->updated_at = 0;
            if ($model->save()) {
                echo(json_encode(['code'=>0,'error'=>'修改成功！']));
            }else{
                echo(json_encode(['code'=>1,'error'=>'修改失败！']));
            }            
            return;
        } else {
            echo(json_encode(['code'=>1,'error'=>'记录不存在！']));
            return;
        }
    }

    /**
     * Deletes an existing PushMessage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PushMessage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PushMessage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PushMessage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
