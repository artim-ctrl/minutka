<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Отзыв';
$this->params['breadcrumbs'][] = ['label' => 'Отзывы', 'url' => ['admin/reviews']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="review-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <? $form = ActiveForm::begin([
        'enableAjaxValidation' => true,
    ]) ?>

        <div class='row'>
            <div class='col-sm-12 col-md-12'>
                <?= $form->field($model, 'content')->textarea([
                    'class' => 'form-control',
                    'placeholder' => 'Введите содержание',
                ]) ?>
            </div>
        </div>

        <div class='row'>
            <div class='col-sm-12 col-md-12'>
                <?= Html::submitButton('Сохранить', [
                    'class' => 'btn btn-outline-success',
                ]) ?>
            </div>
        </div>

    <? ActiveForm::end() ?>

</div>
