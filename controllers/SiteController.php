<?php

namespace app\controllers;

use app\models\Tweet;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(), 'only' => ['logout'], 'rules' => [
                    [
                        'actions' => ['logout'], 'allow' => true, 'roles' => ['@'],
                    ],
                ],
            ], 'verbs' => [
                'class' => VerbFilter::className(), 'actions' => [
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
            ], 'captcha' => [
                'class' => 'yii\captcha\CaptchaAction', 'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
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
     * @return string
     * @throws \Exception
     */
    public function actionUpdate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $twit = new Tweet();

        $twit->updateTweets();

        return 'updated';
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function actionGetUserLocation()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $tweet = new Tweet();

        $cityName = Yii::$app->getUser()->identity->accounts['twitter']->decodedData['location'];

        return $tweet->getGeoData($cityName);
    }
}
