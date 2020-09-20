<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-sm-5 col-md-5">
 
            <? $form = ActiveForm::begin([
                'enableAjaxValidation' => true,
            ]) ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary']) ?>
            <? ActiveForm::end() ?>
 
        </div>
    </div>
</div>
