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

use lo\widgets\modal\ModalAjax;
use yii\helpers\Url;

echo ModalAjax::widget([
    'id' => 'viewTask',
    'header' => Yii::t('app', 'View Task'),
    'size' => ModalAjax::SIZE_LARGE,
    'selector' => 'a.viewTask', // all buttons in grid view with href attribute
    //'url' => Url::to(['/task/1']), // Ajax view with form to load
    'options' => [
        'class' => 'header-primary',
        'data-backdrop' => 'static',
        'data-keyboard' => 'false',
        'tabindex' => false,
    ],
]);

$this->registerJs('
    $(".wrap").on( "click", "a.link-ajax", function(e){
        e.preventDefault();
        var url = $(this).attr("href");
        $.get(url, function(data){
            $(".modal-body").replaceWith(data);
        });
        return false;
    });
');

?>
<div class="desk-index">

    <?= Html::a('<i class="fas fa-cog fa-2x"></i>', ['manage'], ['class'=>'float-right']) ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="container-fluid">
        <div class="row flex-row flex-sm-nowrap">
<?php foreach($model as $item) : ?>
            <div class="col-sm-6 col-md-4 col-xl-3">
                <div class="card bg-light">
                    <div class="card-header text-uppercase text-truncate py-2">
                        <div class="float-right">
                            <a href="/task/create"><i class="fas fa-plus-circle fa-lg"></i></a>
                        </div>
                        <h5><?= $item->name ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="items border border-light">
                            <div class="dropzone rounded" ondrop="drop(event)" ondragover="allowDrop(event)" ondragleave="clearDrop(event)"> &nbsp; </div>
                            <?php foreach($item->tasks as $task) {
                                echo $this->render('_task', ['model'=>$task]);
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
<?php endforeach ?>
        </div>
    </div>


</div>
