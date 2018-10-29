<?php

namespace app\modules\backend\controllers;

use Yii;
use app\models\ChannelSubject;
use app\modules\backend\models\ChannelSubjectSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ChannelSubjectController implements the CRUD actions for ChannelSubject model.
 */
class ChannelSubjectController extends Controller
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
     * Lists all ChannelSubject models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ChannelSubjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ChannelSubject model.
     * @param integer $id
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
        $model =ChannelSubject::find()->where(['id'=>$id])->asArray()->one();
        
        if (empty($model)) {
            echo(json_encode(['code'=>1,'error'=>'记录不存在！']));
            return;
        }else{
            $model['show_start_time']=date('Y-m-d H:i:s',$model['show_start_time']);
            $model['show_end_time']=date('Y-m-d H:i:s',$model['show_end_time']);
            echo(json_encode(['code'=>0,'error'=>'成功','data'=>$model]));
            return;
        }
    }

    /**
     * Creates a new ChannelSubject model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ChannelSubject();
        if ($model->load(Yii::$app->request->post()) ) {
        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // return $this->redirect(['view', 'id' => $model->id]);
            $model->show_start_time = strtotime($model->show_start_time);
            $model->show_end_time = strtotime($model->show_end_time);
            if ($model->save()){
               return $this->redirect('index.html'); 
            }            
        } 
        return $this->render('create', [
                'model' => $model,
            ]);

    }

    /**
     * Updates an existing ChannelSubject model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        $id=\Yii::$app->request->post('id','');
        $model = $this->findModel($id);

        if ($model) {
            $model->channel_title =\Yii::$app->request->post('channel_title','');
            $model->active_title = \Yii::$app->request->post('active_title','');
            $model->show_start_time = strtotime(\Yii::$app->request->post('show_start_time',''));
            $model->show_end_time = strtotime(\Yii::$app->request->post('show_end_time',''));
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
     * Deletes an existing ChannelSubject model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ChannelSubject model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ChannelSubject the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ChannelSubject::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
