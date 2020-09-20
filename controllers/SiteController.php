<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\account\LoginForm;
use app\models\ContactForm;
use yii\web\HttpException;
use app\models\User;
use app\models\account\SignupForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

use app\models\reviews\Reviews;
use app\models\reviews\ReviewsSearch;

class SiteController extends Controller
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
                        'actions' => ['logout', 'contact', 'account'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                    [
                        'actions' => ['login', 'index', 'signup', 'about'],
                        'allow' => true,
                    ],

                    [
                        'actions' => ['review-index', 'review-update'],
                        'allow' => true,
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax && Yii::$app->request->enableCsrfValidation) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if ($model->login()) {
                return $this->goBack();
            }
        }

        $model->password = '';
        return $this->render('account/login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax && Yii::$app->request->enableCsrfValidation) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }
 
        return $this->render('account/signup', [
            'model' => $model,
        ]);
    }

    public function actionAccount()
    {
        $model = User::findOne(Yii::$app->user->identity->id);

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax && Yii::$app->request->enableCsrfValidation) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
            $model->setPassword($model->password);
            $model->update(false);

            return $this->redirect([Url::current()]);
        }
 
        return $this->render('account/account', [
            'model' => $model,
        ]);
    }

    public function actionReviewIndex() {
        $model = new Reviews();

        $reviews = Reviews::find()->where([
            'deleted' => false,
        ])->all();

        return $this->render('reviews/index', [
            'reviews' => $reviews,
            'model' => $model,
        ]);
    }

    public function actionReviewUpdate($id)
    {
        if (!Reviews::find()->where(['id' => $id])->exists()) {
            throw new HttpException(404, 'Такого пользователя не существует.');
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
 
        return $this->render('reviews/index', [
            'model' => $model,
        ]);
    }
}
