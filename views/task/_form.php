<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use app\models\User;
use app\models\Desk;
/* @var $this yii\web\View */
/* @var $model app\models\Task */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_id')->dropDownList( ArrayHelper::map(User::find()->all(), 'id', 'name'), ['prompt' => Yii::t('app', 'Please select')] ) ?>
    <?= $form->field($model, 'desk_id')->dropDownList( ArrayHelper::map(Desk::find()->orderBy('sort')->all(), 'id', 'name'), ['prompt' => Yii::t('app', 'Please select')] ) ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
