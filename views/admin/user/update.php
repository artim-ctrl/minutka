<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Пользователь ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['admin/users']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <? $form = ActiveForm::begin([
        'enableAjaxValidation' => true,
    ]) ?>

        <div class='row'>
            <div class='col-sm-6 col-md-6'>
                <?= $form->field($model, 'username')->textInput([
                    'class' => 'form-control',
                    'placeholder' => 'Введите имя пользователя',
                ]) ?>
            </div>
            <div class='col-sm-6 col-md-6'>
                <?= $form->field($model, 'password')->textInput([
                    'class' => 'form-control',
                    'placeholder' => 'Введите пароль',
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
