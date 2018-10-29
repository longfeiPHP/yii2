<?php

namespace app\modules\backend\controllers;

use Yii;
use app\models\Banner;
use app\modules\backend\models\BannerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\backend\components\AliyunOss;
use app\models\ImgUseHistory;

/**
 * BannerController implements the CRUD actions for Banner model.
 */
class BannerController extends Controller
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

    public function actionTest()
    {
        $ali=new AliyunOss;
        // var_dump(\Yii::$app->params);return;
        // echo $ali->saveFile('avatar','C:\Users\lixiaobo\Desktop\DESTV.png');
         var_dump($ali->delFile('avatar',['t151315Pp56695.png','1l513V1556ZD65.png']));

        return;
    }

    /**
     * Lists all Banner models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BannerSearch();
        $params = Yii::$app->request->queryParams;
        
        if (empty($params['banner_type'])) {
            $banner_type =0;
        }else{
            $banner_type =$params['banner_type'];
        }
        $params[$searchModel->formName()]['banner_type'] = $banner_type;
        // var_dump($params);return;
        $dataProvider = $searchModel->search($params);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'banner_type'=>$banner_type,
        ]);
    }

    /**
     * Displays a single Banner model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Banner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($banner_type =0)
    {
        // var_dump(Yii::$app->request->post());return;
        $model = new Banner();

        if ($model->load(Yii::$app->request->post()) ) {
            $model->img ='';
            $model->show_start_time = strtotime($model->show_start_time);
            $model->show_end_time = strtotime($model->show_end_time);
            $model->live_start_time = strtotime($model->live_start_time);
            $model->live_end_time = strtotime($model->live_end_time);
            $model->banner_type = $banner_type;
            // $max = Banner::getMaxSort();
            $max = ['max'=>0];
            $model->banner_sort=$max['max'];
            $imageFile =[
                'name'=>$_FILES['Banner']['name']['imageFile'],
                'type'=>$_FILES['Banner']['type']['imageFile'],
                'tmp_name'=>$_FILES['Banner']['tmp_name']['imageFile'],
                'error'=>$_FILES['Banner']['error']['imageFile'],
                'size'=>$_FILES['Banner']['size']['imageFile'],
            ];
            if (!empty($imageFile['name'])) {
                $ali=new AliyunOss;
                $img=$ali->saveUploadFile('avatar',$imageFile);
                $model->img = $img;               
            }
            $model->save();
            // return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect('/backend/banner/index.html?banner_type='.$banner_type); 
        } else {
            return $this->render('create', [
                'model' => $model,
                'banner_type' => $banner_type,
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
            $nextsort = $model1->banner_sort -1;
            $msg="已经第一个了";
        }else{
            $nextsort = $model1->banner_sort +1;
            $msg="已经最后一个了";
        }
        $model2 = Banner::findOne(['banner_sort'=>$nextsort,'status'=>1]);
        if (empty($model2)) {
            echo(json_encode(['code'=>0,'error'=>$msg]));
            return;
        }else{
           $model2->banner_sort= $model1->banner_sort;
           $model1->banner_sort= $nextsort;
           $model2->save();
           $model1->save();
        }
        echo(json_encode(['code'=>1,'error'=>'success']));
        return;
    }
    /**
     * 上下架
     * @param integer $id
     * @param string $action
     * @return mixed
     */
    public function actionDel($banner_type,$id)
    {
        $model = $this->findModel($id);
        $model->status = 0;
        $model->sort = 0;
        $model->save();
        $searchModel = new BannerSearch();
        return $this->redirect('/backend/banner/index.html?banner_type='.$banner_type); 
    }

    /**
     * 上下架
     * @param integer $id
     * @param string $action
     * @return mixed
     */
    public function actionAble($banner_type,$id)
    {
        $model = $this->findModel($id);
        $model->status = 1;
        $model->sort = Banner::getMaxSort()['max'];
        $model->save();

        return $this->redirect('/backend/banner/index.html?banner_type='.$banner_type); 
    }

    /**
     * Updates an existing Banner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->id]);
        // } else {
        //     return $this->render('update', [
        //         'model' => $model,
        //     ]);
        // }
        $old_img = $model->img;
        if ($model->load(Yii::$app->request->post()) ) {
            //$model->img ='';
            $model->show_start_time = strtotime($model->show_start_time);
            $model->show_end_time = strtotime($model->show_end_time);
            $model->live_start_time = strtotime($model->live_start_time);
            $model->live_end_time = strtotime($model->live_end_time);
            // $max = Banner::getMaxSort();
            //$max = ['max'=>0];
            //$model->banner_sort=$max['max'];
            $imageFile =[
                'name'=>$_FILES['Banner']['name']['imageFile'],
                'type'=>$_FILES['Banner']['type']['imageFile'],
                'tmp_name'=>$_FILES['Banner']['tmp_name']['imageFile'],
                'error'=>$_FILES['Banner']['error']['imageFile'],
                'size'=>$_FILES['Banner']['size']['imageFile'],
            ];
            $img ="";
            if (!empty($imageFile['name'])) {
                $ali=new AliyunOss;
                $img=$ali->saveUploadFile('avatar',$imageFile);
                $model->img = $img;
                              
            }
            // var_dump($model);return;
            if ($model->save()) {
                if ($img !=""  && $old_img !="" ) {
                    //如果有上传图片则记录已删除的
                    ImgUseHistory::newData($old_img,2);
                }
                return $this->redirect('/backend/banner/index.html?banner_type='.$model->banner_type);
            }
            return $this->redirect(['view', 'id' => $model->id]);
            
        } else {
            return $this->redirect(['view', 'id' => $model->id]);
        }
    }

    /**
     * Deletes an existing Banner model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(['index']);
    // }

    /**
     * Finds the Banner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Banner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Banner::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
