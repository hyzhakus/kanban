<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Desk */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Desks');
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@web/js/desk.js');
?>
<div class="desk-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Desk'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'buttonOptions' => ['class'=>'fa-lg'],
                'icons' => [
                    'eye-open' => '<i class="far fa-eye"></i>',
                    'pencil' => '<i class="fas fa-pencil-alt"></i>',
                     'trash' => '<i class="far fa-trash-alt"></i>',
                ],
            ],

            'sort',
            'name',
        ],
    ]); ?>

    <?php Pjax::end(); ?>


</div>
