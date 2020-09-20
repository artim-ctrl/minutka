<?
    use yii\bootstrap4\ActiveForm;
    use yii\helpers\Html;
?>

<div class='container'>
    <? if (!empty($reviews)) : ?>
        <? foreach ($reviews as $review) : ?>
            <div class='row mb-3'>
                <div class='col-sm-2 col-md-2'>
                    <?= $review->user->getAvatar() ?>

                    <?= $review->user->username ?>

                    <span class='text-muted'><?= date('d.m.Y H:s', $review->created_at) ?></span>
                </div>

                <div class='col-sm-10 col-md-10 review_<?= $review->id ?> collapse'>
                    <? $form_review = ActiveForm::begin([
                        'enableAjaxValidation' => true,
                        'action' => 'update?id=' . $review->id,
                        'method' => 'post',
                    ]) ?>

                        <?= $form_review->field($review, 'content')->textarea([
                            'options' => [
                                'class' => 'form-control',
                            ],
                        ])->label(false) ?>

                        <?= Html::submitButton('Отправить', [
                            'class' => 'btn btn-outline-success w-100',
                            'data-toggle' => 'collapse',
                            'data-target' => '.review_' . $review->id,
                        ]) ?>

                    <? ActiveForm::end() ?>
                </div>

                <div class='col-sm-10 col-md-10 review_<?= $review->id ?> collapse show'>
                    <div class='d-flex justify-content-between'>
                        <?= $review->content ?>
                        
                        <?= Html::button('<i class="fas fa-pencil-alt"></i>', [
                            'title' => 'Изменение',
                            'class' => 'btn btn-sm btn-outline-info',
                            'data-toggle' => 'collapse',
                            'data-target' => '.review_' . $review->id,
                        ]) ?>
                    </div>
                </div>
            </div>
        <? endforeach ?>
    <? else : ?>
        <div class='row mb-3'>
            <div class='col-sm-12 col-md-12'>
                Отзывов пока нет, напишите первый!
            </div>
        </div>
    <? endif ?>

    <div class='row'>
        <div class='col-sm-12 col-md-12'>
            <? $form = ActiveForm::begin([
                'enableAjaxValidation' => true,
            ]) ?>

                <?= $form->field($model, 'content')->textarea([
                    'options' => [
                        'class' => 'form-control',
                    ],
                ])->label(false) ?>

                <?= Html::submitButton('Отправить', [
                    'class' => 'btn btn-outline-success w-100',
                ]) ?>

            <? ActiveForm::end() ?>
        </div>
    </div>
</div>