<?php

use yii\helpers\Html;

?>
<div class="card draggable shadow-sm" id="cd<?= $model->id ?>" draggable="true" ondragstart="drag(event)">
    <div class="card-body p-2">
        <div class="card-title">
            <img src="https://git.oberig.co/uploads/-/system/user/avatar/26/avatar.png" width="40" class="rounded-circle float-right">
            <a href="" class="lead font-weight-light">#<?= $model->id ?> <?=$model->name ?></a>
        </div>
        <?= Html::a(Yii::t('app', 'View'), ['/task/view', 'id'=>$model->id], ['class'=>'viewTask btn btn-primary btn-sm']) ?>
    </div>
</div>
<div class="dropzone rounded" ondrop="drop(event)" ondragover="allowDrop(event)" ondragleave="clearDrop(event)"> &nbsp; </div>
