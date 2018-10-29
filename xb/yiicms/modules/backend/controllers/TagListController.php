<?php

namespace app\modules\backend\controllers;

use Yii;
use app\models\TagList;
use app\modules\backend\models\TagListSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TagListController implements the CRUD actions for TagList model.
 */
class TagListController extends Controller
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
     * Lists all TagList models.
     * @return mixed
     */
    public function actionIndex()
    {
        // var_dump(TagList::AllGroupList());return;
        $searchModel = new TagListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // var_dump($dataProvider);return;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'PNameList'=>TagList::PNameList(),
        ]);
    }

    /**
     * Displays a single TagList model.
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
        $model =TagList::find()->where(['id'=>$id])->asArray()->one();
        
        if (empty($model)) {
            echo(json_encode(['code'=>1,'error'=>'记录不存在！']));
            return;
        }else{
            $model['PNameList']=TagList::PNameList();
            echo(json_encode(['code'=>0,'error'=>'成功','data'=>$model]));
            return;
        }
    }

    /**
     * Creates a new TagList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TagList();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TagList model.
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
            $model->pid =\Yii::$app->request->post('pid','');
            $model->key = \Yii::$app->request->post('key','');
            $model->name = \Yii::$app->request->post('name','');
            $model->title = \Yii::$app->request->post('title','');
            $checkModel = TagList::findOne(['key'=>\Yii::$app->request->post('key','')]);
            if (!empty($checkModel) && $checkModel->id != $id) {
                echo(json_encode(['code'=>2,'error'=>'标签号重复']));
                return;
            }

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
     * Deletes an existing TagList model.
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
     * Finds the TagList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TagList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TagList::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    
}
