<?php
/**
 * Created by PhpStorm.
 * User: david
 */
/** @var $model app\models\Products */
use yii\helpers\Url;
use app\helpers\StringHelper;
?>
<div class="col-sm-6 col-md-4">
    <div class="thumbnail">
        <div class="image-box">
            <a href="<?=Url::to(['/photos/item', 'id'=>$model->id])?>">
                <img alt="<?=$model->title?>" src="<?=$model->image?>" class="image">
            </a>
        </div>
        <div class="caption">
            <h5>
                <a href="<?=Url::to(['/photos/item', 'id'=>$model->id])?>" title="<?=$model->title?>">
                    <?=StringHelper::truncateUtf8String($model->title, 13, false)?>
                </a>
            </h5>
            <div style="height: 40px;overflow: hidden;">
                <?=$model->description?>
            </div>
        </div>
    </div>
</div>
