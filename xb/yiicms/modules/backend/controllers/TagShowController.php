<?php

namespace app\modules\backend\controllers;

use Yii;
use app\models\TagShow;
use app\modules\backend\models\TagShowSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\TagList;

/**
 * TagShowController implements the CRUD actions for TagShow model.
 */
class TagShowController extends Controller
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
     * Lists all TagShow models.
     * @return mixed
     */
    public function actionIndex()
    {
        // var_dump(TagShow::getTag0());return;
        $searchModel = new TagShowSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TagShow model.
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
        $model =TagShow::find()->joinWith('tagInfo')->where(['ww_tag_show.id'=>$id])->asArray()->one();
        
        if (empty($model)) {
            echo(json_encode(['code'=>1,'error'=>'记录不存在！']));
            return;
        }else{
            $model['appName']=TagShow::getAppName();
            $model['regionName']=TagShow::getRegionName();
            $model['tagGropuList']  =TagList::AllGroupList();
            echo(json_encode(['code'=>0,'error'=>'成功','data'=>$model]));
            return;
        }
    }

    /**
     * Creates a new TagShow model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TagShow();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // return $this->redirect(['view', 'id' => $model->id]);
            return $this->render('index');
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 排序.
     * @param integer $id
     * @param string $action
     * @return mixed
     */
    public function actionSort()
    {
        Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        $id=\Yii::$app->request->post('id','');
        $action=\Yii::$app->request->post('action','');
        $actions=['up','down'];
        if (empty($id)||empty($action) || !in_array($action,$actions)) {
            echo(json_encode(['code'=>0,'error'=>'param error']));
            return;
        }

        $model1 = $this->findModel($id);
        if ($action=='up') {
            $nextsort = $model1->sort -1;
            $msg="已经第一个了";
        }else{
            $nextsort = $model1->sort +1;
            $msg="已经最后一个了";
        }

        $model2 = TagShow::findOne(['sort'=>$nextsort,'status'=>1]);

        
        if (empty($model2)) {
            echo(json_encode(['code'=>0,'error'=>$msg]));
            return;
        }else{
           $model2->sort= $model1->sort;
           $model1->sort= $nextsort;
           $model2->save();
           $model1->save();
        }
        echo(json_encode(['code'=>1,'error'=>'success']));
        return;
    }

    /**
     * Updates an existing TagShow model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    {
        Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        $id=\Yii::$app->request->post('id','');
        $tag_list_id = \Yii::$app->request->post('tag_list_id','');
        $tag_app_key = \Yii::$app->request->post('tag_app_key','');
        $tag_region_id = \Yii::$app->request->post('tag_region_id','');
        $where =[
            'tag_list_id'=>$tag_list_id,
            'tag_app_key'=>$tag_app_key,
            'tag_region_id'=>$tag_region_id,
        ];
        $checkModel = TagShow::find()->where($where)->one();
        if ($checkModel) {
            if ($checkModel->id != $id) {
                echo(json_encode(['code'=>1,'error'=>'修改失败！标签已经在该app的区域中使用！']));
                return;
            }
            
        }
        $model = $this->findModel($id);
        if ($model) {
            $model->tag_list_id = \Yii::$app->request->post('tag_list_id','');
            $model->tag_app_key = \Yii::$app->request->post('tag_app_key','');
            $model->tag_region_id = \Yii::$app->request->post('tag_region_id','');
            $model->status =0;
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
     * 上下架
     * @param integer $id
     * @param string $action
     * @return mixed
     */
    public function actionAble($id)
    {
        $model = $this->findModel($id);
        $model->status = 1;
        $model->sort = TagShow::getMaxSort()['max'];
        // var_dump($model);return;
        $model->save();

        return $this->redirect('index.html'); 
    }

    /**
     * Deletes an existing TagShow model.
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
     * 上下架
     * @param integer $id
     * @param string $action
     * @return mixed
     */
    public function actionDel($id)
    {
        $model = $this->findModel($id);
        $model->status = 0;
        $model->sort = 0;
        $model->save();
        return $this->redirect('index.html'); 
    }

    /**
     * Finds the TagShow model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TagShow the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TagShow::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
