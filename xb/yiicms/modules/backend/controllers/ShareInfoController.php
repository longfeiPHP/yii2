<?php

namespace app\modules\backend\controllers;

use Yii;
use app\models\ShareInfo;
use app\modules\backend\models\ShareInfoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\ImgUseHistory;
/**
 * ShareInfoController implements the CRUD actions for ShareInfo model.
 */
class ShareInfoController extends Controller
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
     * Lists all ShareInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
       // var_dump(array_unshift(ShareInfo::$eventList,'全部'));
       // $temp =ShareInfo::$eventList;
       // array_unshift($temp,[""=>'全部']);
       // $temp [""]='全部';
       // var_dump($temp);
       // return; 
        $searchModel = new ShareInfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ShareInfo model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ShareInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ShareInfo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ShareInfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $old_img = $model->img_url;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->img_url !=""  && $old_img !="" && $old_img != $model->img_url  ) {
                //如果有上传图片则记录已删除的
                ImgUseHistory::newData($old_img,2);
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 上架
     * @param integer $id
     * @param string $action
     * @return mixed
     */
    public function actionAble($id)
    {
        $model = $this->findModel($id);
        $model->status = 1;
        // var_dump($model);return;
        $model->save();

        return $this->redirect('index.html'); 
    }

    /**
     * 下架
     * @param integer $id
     * @param string $action
     * @return mixed
     */
    public function actionDel($id)
    {
        $model = $this->findModel($id);

        $model->status = 0;
        // var_dump($model);
        $model->save();
        return $this->redirect('index.html'); 
    }

    /**
     * Finds the ShareInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ShareInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShareInfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
