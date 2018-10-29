<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\ShareInfo;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\backend\models\ShareInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '分享文案管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="share-info-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新建', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options'=>['class' => 'panel panel-default'],
        // 'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            'id',
            // 'event',
            [
                'attribute'=>'event',
                 'value'=>function($dataProvider){
                    return ShareInfo::getEventName($dataProvider->event);
                },
            ],
            // 'platform',
            [
                'attribute'=>'platform',
                 'value'=>function($dataProvider){
                    return ShareInfo::getPlatName($dataProvider->platform);
                },
            ],
            'title',
            'summary',
            // 'img_url:url',
            ['attribute'=>'img_url',
            // 'label'=>'活动图',
            'value'=>function($dataProvider){
                if (!empty($dataProvider->img_url)) {
                    $url =  \yii::$app->params['imgcdn'].$dataProvider->img_url;
                    $options=[
                        'height'=>'30',
                        'data-toggle'=>"modal", 
                        'data-target'=>"#myModal",
                        'style'=>"cursor:pointer",
                    ];
                    return \yii\helpers\Html::img($url,$options);
                }
                return '';
                },
            'format'=>'raw'
            ],
            'target_url:url',
            // 'status',
            [
                'attribute'=>'status',
                 'value'=>function($dataProvider){
                    // return $dataProvider->status;
                    return ShareInfo::getStatus($dataProvider->status);
                },
            ],
            // 'created_at',
            // 'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{del}{able}',
                'header' => '操作',
                'headerOptions'=>['style'=>'width:2%;'],
                'buttons' => [
                    'del' => function ($url, $model, $key) { 
                    return Html::a('下线', 
                        ['del','id'=>$model->id], 
                        ['class' => 'btn  btn-danger btn-xs',
                        'title'=>'下线分享',
                        'data' => [
                            'confirm' => '你确定要下线此分享吗?',
                            'method' => 'post',
                            ],
                        ]); 
                    },
                    'update' => function ($url, $model, $key) { 
                    return Html::a('修改', 
                        $url, 
                        ['class' => 'btn  btn-primary btn-xs',
                        'title'=>'修改分享',
                       ]); 
                    },
                    'able' => function ($url, $model, $key) { 
                    return Html::a('上线', 
                        ['able','id'=>$model->id], 
                        ['class' => 'btn  btn-success btn-xs',
                        'title'=>'上线分享',
                        'data' => [
                            'confirm' => '你确定要上线此分享吗?',
                            'method' => 'post',
                            ],
                        ]); 
                    },
                ],
                'visibleButtons'=>[
                'del'=>function ($model, $key, $index) {
                    //...coding                     
                    return $model->status === 1;
                    },
                'able'=>function ($model, $key, $index) {
                    //...coding                     
                    return $model->status === 0;
                    },
                ],
            ],
        ],
    ]); ?>
</div>
<?php include(dirname(dirname(__FILE__))."/common/ImageView.php") ?>