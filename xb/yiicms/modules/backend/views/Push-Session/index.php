<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\PushSession;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\backend\models\PushSessionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '创建类型';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="push-session-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建类型', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options'=>['class' => 'panel panel-default'],
        // 'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            'id',
            'type',
            'ww_id',
            'nickname',
            // 'avatar',
            ['attribute'=>'avatar',
            // 'label'=>'活动图',
            'value'=>function($dataProvider){
                if (!empty($dataProvider->avatar)) {
                    $url = \yii::$app->params['imgcdn']. $dataProvider->avatar;
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
            // 'verified',
            [
                'attribute'=>'verified',
                'value'=>function($dataProvider){
                    return PushSession::$VerifyArr[$dataProvider->verified];
                }
            ],
            // 'status',
            [
                'attribute'=>'status',
                'value'=>function($dataProvider){
                    return PushSession::$StatusArr[$dataProvider->status];
                }
            ],

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
                        'title'=>'下线帐号',
                        'data' => [
                            'confirm' => '你确定要下线此帐号吗?',
                            'method' => 'post',
                            ],
                        ]); 
                    },
                    'update' => function ($url, $model, $key) { 
                    return Html::a('修改', 
                        $url, 
                        ['class' => 'btn  btn-primary btn-xs',
                        'title'=>'修改帐号',
                       ]); 
                    },
                    'able' => function ($url, $model, $key) { 
                    return Html::a('上线', 
                        ['able','id'=>$model->id], 
                        ['class' => 'btn  btn-success btn-xs',
                        'title'=>'上线帐号',
                        'data' => [
                            'confirm' => '你确定要上线此帐号吗?',
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