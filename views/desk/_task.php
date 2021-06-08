<?php

use yii\helpers\Html;

?>
<div class="card draggable shadow-sm" id="cd<?= $model->id ?>" draggable="true" ondragstart="drag(event)">
    <div class="card-body p-2">
        <div class="card-title">
            <div class="float-right">
                <?= \app\widgets\ShowFile::widget(['user_id'=>$model->user_id]) ?>
            </div>
            <?= Html::a('#'.$model->id.' '.$model->name, ['/task/view', 'id'=>$model->id], ['class'=>'viewTask lead font-weight-light']) ?>
        </div>
        <?= Html::a(Yii::t('app', 'View'), ['/task/view', 'id'=>$model->id], ['class'=>'viewTask btn btn-primary btn-sm']) ?>
    </div>
</div>
<div class="dropzone rounded" ondrop="drop(event)" ondragover="allowDrop(event)" ondragleave="clearDrop(event)"> &nbsp; </div>
