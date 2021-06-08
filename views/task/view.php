<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Task */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tasks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="task-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary link-ajax']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], ['class' => 'btn btn-danger link-ajax',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'user_id',
                'value' => function($model) {
                    return $model->user->name;
                }
            ],
            [
                'attribute' => 'desk_id',
                'value' => function($model) {
                    return $model->desk->name;
                }
            ],
            [
                'attribute' => 'name',
                'value' => function($model) {
                    return '#'.$model->id.'. '.$model->name;
                }
            ],
            'note:ntext',
        ],
    ]) ?>

    <div class="text-center">
        <?= Html::button(Yii::t('app', 'Close'), ['class' => 'btn btn-primary', 'data-dismiss'=>'modal']) ?>
    </div>

</div>
