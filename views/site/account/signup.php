<?php
 
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
 
$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <div class="row">
        <div class="col-sm-5 col-md-5">
 
            <? $form = ActiveForm::begin([
                'id' => 'form-signup',
                'enableAjaxValidation' => true,
            ]) ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'password_confirm')->passwordInput() ?>

                <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary']) ?>
            <? ActiveForm::end() ?>
 
        </div>
    </div>
</div>