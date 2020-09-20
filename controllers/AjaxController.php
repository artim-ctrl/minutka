<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\json;

use app\models\User;
use app\models\reviews\Reviews;

class AjaxController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['error'],
                        'allow' => true,
                    ],

                    [
                        'actions' => ['get-users', 'get-reviews'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
                'denyCallback' => function () {
                    throw new HttpException(403, "У вас нет прав, для отображения данной страницы.");
                }
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionGetUsers($q = false, $field, $where = false) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $query = User::find()->select([$field]);

        if ($q !== false) {
            $query = $query->andFilterWhere(['ilike', $field, $q]);
        }

        $query = $query->asArray()->all();

        $arr = [];

        if (!empty($query)) {
            foreach ($query as $key => $user) {
                $arr[] = ['id' => $user[$field], 'text' => $user[$field]];
            }
        }

        return [
            'results' => $arr,
        ];
    }

    public function actionGetReviews($q = false, $with = false, $field, $where = false) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $query = Reviews::find();

        if ($with !== false) {
            $query = $query->joinWith([$with]);
        }
        
        $query = $query->select([($with ? ($with . '.') : '') . $field]);

        if ($q !== false) {
            $query = $query->andFilterWhere(['ilike', ($with ? ($with . '.') : '') . $field, $q]);
        }

        $query = $query->asArray()->all();

        $arr = [];

        if (!empty($query)) {
            foreach ($query as $key => $review) {
                $arr[] = ['id' => $review[$field], 'text' => $review[$field]];
            }
        }

        return [
            'results' => $arr,
        ];
    }
}