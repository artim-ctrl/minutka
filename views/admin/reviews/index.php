<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\web\JsExpression;
use kartik\daterange\DateRangePicker;

$this->title = 'Отзывы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <? Pjax::begin(['id' => 'pjax-reviews', 'timeout' => false]) ?>

        <?= GridView::widget([
            'layout' => '<div class=\'mb-2 d-flex flex-row-reverse justify-content-between align-items-center\'>' . Html::button('<i class="fas fa-redo"></i>', ['class' => 'btn btn-outline-dark', 'onclick' => '$.pjax.reload({ container: \'#pjax-reviews\' })']) . '{summary}</div>{items}{pager}',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'contentOptions' => [
                        'class' => [
                            'text-center',
                            'align-middle',
                        ],
                    ],
                ],

                [
                    'attribute' => 'id',
                    'filter'=> Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'id',
                        'options' => [
                            'placeholder' => '',
                            'multiple' => true,
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'ajax' => [
                                'url' => '/ajax/get-reviews',
                                'dataType' => 'json',
                                'data' => new JsExpression('
                                    function (params) {
                                        return {
                                            q: params.term,
                                            field: "id"
                                        };
                                    }'
                                ),
                            ],
                        ],
                    ]),
                    'contentOptions' => [
                        'class' => [
                            'text-center',
                            'align-middle'
                        ],
                    ],
                ],
                [
                    'attribute' => 'user.username',
                    'filter'=> Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'username',
                        'options' => [
                            'placeholder' => '',
                            'multiple' => true,
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'ajax' => [
                                'url' => '/ajax/get-reviews',
                                'dataType' => 'json',
                                'data' => new JsExpression('
                                    function (params) {
                                        return {
                                            q: params.term,
                                            field: "username",
                                            with: "user"
                                        };
                                    }'
                                ),
                            ],
                        ],
                    ]),
                    'contentOptions' => [
                        'class' => [
                            'text-center',
                            'align-middle'
                        ],
                    ],
                ],
                [
                    'attribute' => 'content',
                    'filter'=> Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'content',
                        'options' => [
                            'placeholder' => '',
                            'multiple' => true,
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'ajax' => [
                                'url' => '/ajax/get-reviews',
                                'dataType' => 'json',
                                'data' => new JsExpression('
                                    function (params) {
                                        return {
                                            q: params.term,
                                            field: "content"
                                        };
                                    }'
                                ),
                            ],
                        ],
                    ]),
                    'contentOptions' => [
                        'class' => [
                            'text-center',
                            'align-middle'
                        ],
                    ],
                ],
                [
                    'format' => 'raw',
                    'attribute' => 'deleted',
                    'filter'=> Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'deleted',
                        'data' => [
                            true => 'Да',
                            false => 'Нет',
                        ],
                        'options' => [
                            'placeholder' => '',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]),
                    'contentOptions' => [
                        'class' => [
                            'text-center',
                            'align-middle',
                        ],
                    ],
                    'value' => function ($data) {
                        return $data['deleted'] ? 'Да' : 'Нет';
                    }
                ],
                [
                    'attribute' => 'created_at',
                    'label' => 'Дата изменения',
                    'contentOptions' => [
                        'class' => [
                            'text-center',
                            'align-middle',
                        ],
                    ],
                    'filter' => DateRangePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'created_at',
                        'convertFormat' => true,
                        'pluginOptions' => [
                            'timePicker' => true,
                            'timePicker24Hour' => true,
                            'timePickerIncrement' => 10,
                            'locale' => [
                                'format' => 'd.m.Y H:i',
                                'showMeridian' => false,
                            ],
                        ],
                        'options' => [
                            'autocomplete' => 'off',
                            'class' => 'form-control',
                        ],
                    ]),
                    'value' => function ($data) {
                        return date('d.m.Y H:i:s', $data['created_at']);
                    }
                ],
                [
                    'attribute' => 'updated_at',
                    'label' => 'Дата изменения',
                    'contentOptions' => [
                        'class' => [
                            'text-center',
                            'align-middle',
                        ],
                    ],
                    'filter' => DateRangePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'updated_at',
                        'convertFormat' => true,
                        'pluginOptions' => [
                            'timePicker' => true,
                            'timePicker24Hour' => true,
                            'timePickerIncrement' => 10,
                            'locale' => [
                                'format' => 'd.m.Y H:i',
                                'showMeridian' => false,
                            ],
                        ],
                        'options' => [
                            'autocomplete' => 'off',
                            'class' => 'form-control',
                        ],
                    ]),
                    'value' => function ($data) {
                        return date('d.m.Y H:i:s', $data['updated_at']);
                    }
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{admin/review/update} {admin/review/delete}',
                    'contentOptions' => [
                        'class' => [
                            'text-center',
                            'align-middle'
                        ],
                    ],
                    'buttons' => [
                        'admin/review/update' => function ($url, $model) {
                            return Html::a('<i class="fas fa-pencil-alt"></i>', $url, [
                                'title' => 'Изменение',
                                'class' => 'btn btn-sm btn-outline-info',
                            ]);
                        },
                        'admin/review/delete' => function ($url, $model) {
                            return Html::a('<i class="fas fa-trash"></i>', $url, [
                                'title' => 'Удаление',
                                'data' => [
                                    'method' => 'post',
                                    'confirm' => 'Вы уверены, что хотите удалить?',
                                ],
                                'class' => 'btn btn-sm btn-outline-danger',
                            ]);
                        },
                    ],
                ],
            ],
        ]) ?>

    <? Pjax::end() ?>

</div>
