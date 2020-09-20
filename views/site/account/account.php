<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account">

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
                <?= $form->field($model, 'password')->passwordInput([
                    'class' => 'form-control',
                    'placeholder' => 'Введите пароль',
                ]) ?>
            </div>
        </div>

        <div class='row'>
            <div class='col-sm-12 col-md-12 d-flex justify-content-between'>
                <?= Html::submitButton('Сохранить', [
                    'class' => 'btn btn-outline-success',
                ]) ?>

                <?= Html::button('Выйти', [
                    'class' => 'btn btn-outline-danger',
                    'onclick' => '$.ajax({ url: \'/site/logout\', type: \'post\' })',
                ]) ?>
            </div>
        </div>

    <? ActiveForm::end() ?>

</div>
