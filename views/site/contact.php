<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Связь с нами';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <? if (Yii::$app->session->hasFlash('contactFormSubmitted')) : ?>

        <div class="alert alert-success">
            Спасибо! Мы ответим вам в ближайшее время!
        </div>

    <? else : ?>

        <div class="row">
            <div class="col-sm-5 col-md-5">

                <? $form = ActiveForm::begin([
                    'enableAjaxValidation' => true,
                ]) ?>

                    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
                    <?= $form->field($model, 'email') ?>
                    <?= $form->field($model, 'subject') ?>
                    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
                <? ActiveForm::end() ?>
            </div>
        </div>

    <? endif ?>
</div>
