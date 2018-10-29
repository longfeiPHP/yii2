<?php

namespace app\modules\backend\controllers;

use app\models\Content;
use app\models\ContentDetail;
use Yii;
use app\models\News;
use app\modules\backend\models\NewsSearch;
use app\modules\backend\components\BackendController;
use app\modules\backend\actions\ContentCheckAction;
use app\modules\backend\actions\ContentDeleteAllAction;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\ImgUseHistory;

/**
 * ContentController implements the CRUD actions for Content model.
 */
class NewsController extends BackendController
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
    public function actions()
    {
        return array_merge(parent::actions(),[
            'check'=>[
                'class'=>ContentCheckAction::className(),
                'type'=>Content::TYPE_NEWS,
                'status'=>Content::STATUS_ENABLE
            ],
            'un-check'=>[
                'class'=>ContentCheckAction::className(),
                'type'=>Content::TYPE_NEWS,
                'status'=>Content::STATUS_DISABLE
            ],
            'delete-all'=>[
                'class'=>ContentDeleteAllAction::className(),
                'type'=>Content::TYPE_NEWS,
            ]
        ]);
    }
    /**
     * Lists all Content models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->module->params['pageSize']);
        // var_dump(Yii::$app->request->queryParams);die(0);
        // var_dump($searchModel);var_dump($dataProvider);return;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single Content model.
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
     * Creates a new Content model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new News();
        $post = Yii::$app->request->post();
        if ($post) {
            if ($model->load($post) && $model->save()) {
                $new_html = Yii::$app->request->post('ContentDetail')['detail'];
                static::diffImg('',$new_html);
                return $this->showFlash('添加成功','success');
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Content model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $old_img = $model->image;
        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        if ($model->load(Yii::$app->request->post())) {
            $model2=ContentDetail::findOne(['content_id'=>$id]);
            // var_dump($model2);
            $old_html = $model2->detail;
            $new_html = Yii::$app->request->post('ContentDetail')['detail'];

            if ($model->save()) {
                /*存已经更换掉的头图*/
                $controllerID = ucfirst(\Yii::$app->controller->id);
                $new_img =  \yii\web\UploadedFile::getInstancesByName($controllerID);
                // var_dump($new_img);return;
                if (!empty($new_img) && $old_img !="") {
                    //如果有上传图片则记录已删除的
                    ImgUseHistory::newData($old_img,2);

                }
                /*存已经更换掉的文章图*/
                static::diffImg($old_html,$new_html);

                return $this->showFlash('修改文章成功','success');
            }else{
                return $this->showFlash('修改文章失败','warning');
            }
            // var_dump($new_html);
            // $html ='<p>继承测试斯蒂芬大夫撒旦法大赛复赛的1</p><img src="http://ww-mybucket.oss-cn-beijing.aliyuncs.com/ueditor/2.jpg" title="1513829747137850.jpg" alt="bdbg.jpg"/><a href="http://www.sina.com/a.jpg"></a><p><img src="http://ww-mybucket.oss-cn-beijing.aliyuncs.com/ueditor/15v1h3j82V9747.jpg" title="1513829747137850.jpg" alt="bdbg.jpg"/></p>';
            
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /*
    *标记两个html字符串img标签
    */
    public static function diffImg($old_html,$new_html)
    {
        //读取旧的img
        preg_match_all('/<img.*?src=\"(.*?.*?)\".*?>/i', $old_html, $old_matches);
        //读取新的img
        preg_match_all('/<img.*?src=\"(.*?.*?)\".*?>/i', $new_html, $new_matches);

        $temp_del_array= array_diff($old_matches[1],$new_matches[1]);
        $temp_new_array= array_diff($new_matches[1],$old_matches[1]);
        $del_array =$new_array=[];
        foreach ($temp_del_array as $key => $value) {
            preg_match('/(^http:\/\/.*?\/)?([^# ]*)/',$value,$url);
            yii::info(var_export($url,true));
            if (!empty($url[2])) {
                array_push($del_array, $url[2]);
            }            
        }

        foreach ($temp_new_array as $key => $value) {
            preg_match('/(^http:\/\/.*?\/)?([^# ]*)/',$value,$url);
            yii::info(var_export($url,true));
            if (!empty($url[2])) {
                array_push($new_array, $url[2]);
            } 
        }

        if (!empty($new_array)) {
            $query = 'update ww_img_use_history set `status` = 1 where image in ("';
            $query .= implode('","', $new_array) .'")';
            \Yii::$app->db->createCommand($query)->execute();
        }
        if (!empty($del_array)) {
           $imgs = implode(";", $del_array);
            ImgUseHistory::newData($imgs,2);
        }
        
        
        return;
    }

    /**
     * Deletes an existing Content model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    // public function actionDelete($id)
    // {
    //     if($this->findModel($id)->delete()){
    //         return $this->showFlash('删除成功','success',['index']);
    //     }
    //     return $this->showFlash('删除失败','danger',Yii::$app->getUser()->getReturnUrl());
    // }

    /**
     * Finds the Content model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
