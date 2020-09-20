<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\HttpException;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

use app\models\User;
use app\models\UserSearch;
use app\models\reviews\Reviews;
use app\models\reviews\ReviewsSearch;

class AdminController extends Controller
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
                        'actions' => ['user-index', 'user-delete', 'user-update'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],

                    [
                        'actions' => ['review-index', 'review-delete', 'review-update'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        return $action->controller->redirect('/login');
                    } else {
                        throw new HttpException(403, "У вас нет прав, для отображения данной страницы.");
                    }
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

    public function actionUserIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('user/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUserDelete($id)
    {
        if (!User::find()->where(['id' => $id])->exists()) {
            throw new HttpException(404, 'Такого пользователя не существует.');
        }

        User::deleteRow($id);

        return $this->redirect(['admin/users']);
    }

    public function actionUserUpdate($id)
    {
        if (!User::find()->where(['id' => $id])->exists()) {
            throw new HttpException(404, 'Такого пользователя не существует.');
        }

        $model = User::findOne($id);

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax && Yii::$app->request->enableCsrfValidation) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
            $model->setPassword($model->password);
            $model->update(false);

            return $this->redirect([Url::current()]);
        }
 
        return $this->render('user/update', [
            'model' => $model,
        ]);
    }

    public function actionReviewIndex()
    {
        $searchModel = new ReviewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('reviews/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReviewDelete($id)
    {
        if (!Reviews::find()->where(['id' => $id])->exists()) {
            throw new HttpException(404, 'Такого отзыва не существует.');
        }

        Reviews::deleteRow($id);

        return $this->redirect(['admin/reviews']);
    }

    public function actionReviewUpdate($id)
    {
        if (!Reviews::find()->where(['id' => $id])->exists()) {
            throw new HttpException(404, 'Такого отзыва не существует.');
        }

        $model = Reviews::findOne($id);

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax && Yii::$app->request->enableCsrfValidation) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
            $model->update(false);

            return $this->redirect([Url::current()]);
        }
 
        return $this->render('reviews/update', [
            'model' => $model,
        ]);
    }
}
