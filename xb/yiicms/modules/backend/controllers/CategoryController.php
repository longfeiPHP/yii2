<?php

namespace app\modules\backend\controllers;

use app\models\Content;
use Yii;
use app\models\Category;
use app\modules\backend\models\CategorySearch;
use app\modules\backend\components\BackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\backend\components\AliyunOss;
use app\models\ImgUseHistory;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends BackendController
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
     * Lists all Category models.
     * @param int $type
     * @return mixed
     */
    public function actionIndex($type)
    {
        $searchModel = new CategorySearch();
        $params = Yii::$app->request->queryParams;
        $params[$searchModel->formName()]['type'] = $type;

        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type'=>$type,
        ]);
    }

    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param int $type
     * @return mixed
     */
    public function actionCreate($type)
    {
        $model = new Category();

        // $actionID = Yii::$app->controller->action->id;
        // var_dump($controllerID);var_dump($actionID);return;
        // var_dump(Yii::$app->request->post());return;
        $model->type = $type;
        if ($model->load(Yii::$app->request->post())) {
            // var_dump($model);echo "<hr>";
            $Pmodel = (object)null;
            if ($model->pid=="0") {
                $Pmodel->type = $type;
                $Pmodel->path ="";
                $Pmodel->id ="";
            }else{
               $Pmodel =Category::findOne(['id'=> $model->pid]);
                if (empty($Pmodel)) {
                    return $this->showFlash('添加分类失败','warning');
                } 
            }
            
            $model->type = $Pmodel->type;
            $temp_path = $Pmodel->path;
            if ($temp_path=="") {
                $model->path = $Pmodel->id;
            }else{
                $model->path = $Pmodel->path.'/'.$Pmodel->id;
            }
            /*
            $controllerID = ucfirst(Yii::$app->controller->id);
            $imageFile =[
                'name'=>var_export($this->imageFile->name,true),
                'type'=>var_export($this->imageFile->type,true),
                'tmp_name'=>var_export($this->imageFile->tempName,true),
                'error'=>var_export($this->imageFile->error,true),
                'size'=>var_export($this->imageFile->size,true),
            ];
            if (!empty($imageFile['name'])) {
                $ali=new AliyunOss;
                $img=$ali->saveUploadFile($controllerID,$imageFile);
                $model->image = $img;               
            }*/
            // var_dump($model);var_dump($img);return;
            
            if ($model->save()) {
                return $this->showFlash('添加分类成功','success');
            }else{
                return $this->showFlash('添加分类失败','warning');
            }
            
        }
      
        return $this->render('create', [
            'model' => $model,
            'type'=>$type,
        ]);
        
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $old_img = $model->image;
        \Yii::info($old_img);
        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                /*存已经更换掉的头图*/
                $controllerID = ucfirst(\Yii::$app->controller->id);
                $new_img =  \yii\web\UploadedFile::getInstancesByName($controllerID);
                \Yii::info($new_img);
                // var_dump($new_img);return;
                if (!empty($new_img) && $old_img !="") {
                    //如果有上传图片则记录已删除的
                    ImgUseHistory::newData($old_img,2);

                }
                return $this->showFlash('修改分类成功','success');
            }else{
                return $this->showFlash('修改文章失败','warning');
            }

            
        } else {
            return $this->render('update', [
                'model' => $model,
                'type'=>$model->type,
            ]);
        }
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        Content::$currentType =null;
        $content = Content::find()->where(['category_id'=>$id])->limit(1)->one();
        if($content){
            return $this->showFlash('此分类下有内容，不可删除', Yii::$app->getUser()->getReturnUrl());
        }
        if($model->delete()){
            return $this->showFlash('删除成功','success', Yii::$app->getUser()->getReturnUrl());
        }
        return $this->showFlash('删除失败','danger', Yii::$app->getUser()->getReturnUrl());
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
