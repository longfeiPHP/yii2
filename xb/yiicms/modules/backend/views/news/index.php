<?php

use yii\helpers\Html;
use app\modules\backend\widgets\GridView;
use yii\grid\CheckboxColumn;
use app\modules\backend\grid\DataColumn;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\backend\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $pagination yii\data\Pagination */

$this->title = '文章列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-index">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><?= Html::a('文章列表', ['index']) ?></li>
            <li role="presentation"><?= Html::a('添加文章', ['create']) ?></li>
        </ul>
        <div class="tab-content">
            <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                // 'filterModel' => $searchModel,
                'columns' => [
                    ['class' => CheckboxColumn::className()],
                    [
                        'attribute' => 'id',
                        'options' => ['style' => 'width:50px']
                    ],
                    'title',
//            'image',
                    [
                        'attribute'=>'image',
                        'label'=>'活动图',
                        'value'=>function($dataProvider){
                            if (!empty($dataProvider->image)) {
                                $url = \yii::$app->params['imgcdn']. $dataProvider->image;
                                $options=[
                                    'height'=>'30',
                                    'data-toggle'=>"modal", 
                                    'data-target'=>"#myModal",
                                ];
                                return \yii\helpers\Html::img($url,$options);
                            }
                            return '';
                            },
                        'format'=>'raw'
                    ],
                    // 'category_id',
                    [
                        'attribute'=>'category_id',
                        'label'=>'分类',
                        'value' => 'categorytree.name'
                    ],
                    'description',
                    [
                        'attribute' => 'status',
                        'filter'=>$searchModel::$statusList,
                        'options' => ['style' => 'width:60px'],
                        'format' => 'html',
                        'value' => function ($item) {
                            if($item['status']==\app\models\News::STATUS_ENABLE) {
                                return '<span class="badge bg-green">' . $item['statusText'] . '</span>';
                            }else{
                                return '<span class="badge">' . $item['statusText'] . '</span>';
                            }
                        }
                    ],
                    // 'admin_user_id',
                    // [
                    //     'attribute' =>'hits',
                    //     'options' => ['style' => 'width:70px']
                    // ],
                    [
                        'filterType'=>'date',
                        'attribute' => 'created_at',
                        'format' => 'datetime',
                        'options' => ['style' => 'width:160px']
                    ],
//             'updated_at:datetime',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'options' => ['style' => 'width:70px'],
                        'template' => '{update}{check}{un-check}',
                        'header' => '操作',
                        'buttons' => [
                            'update' => function ($url, $model, $key) { 
                                return Html::a('编辑', 
                                    $url, 
                                    ['class' => 'btn  btn-block btn-primary btn-xs',
                                    'title'=>'编辑活动',
                                    'data-id'=>$model->id,
                                    // 'data-toggle'=>"modal", 
                                    // 'data-target'=>"#editModal",
                                    ]); 
                            },
                            'check' => function ($url, $model, $key) { 
                                  
                                return Html::tag('button', '发布',[
                                    'class'=>'content-operation btn btn-block  btn-xs btn-success',
                                    'title'=>'发布活动',
                                    'data-id'=>$model->id,
                                    'data-action'=>Url::to(['check']),
                                ]);

                            },
                            'un-check' => function ($url, $model, $key) { 
                               
                                return Html::tag('button', '下线',[
                                    'class'=>'content-operation btn btn-block  btn-xs btn-danger',
                                    'title'=>'下线活动',
                                    'data-id'=>$model->id,
                                    'data-action'=>Url::to(['un-check']),
                                ]);
                            },


                        ],
                        'visibleButtons'=>[
                            'check'=>function ($model, $key, $index) {
                                //...coding                     
                                return $model->status === 0;
                                },
                            'un-check'=>function ($model, $key, $index) {
                                //...coding                     
                                return $model->status === 1;
                                }
                        ],

                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
<?php include(dirname(dirname(__FILE__))."/common/ImageView.php") ?>
