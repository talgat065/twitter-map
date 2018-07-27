<?php

namespace app\controllers;

use yii\rest\ActiveController;
use app\models\Tweet;
use yii\web\Controller;

class TweetController extends Controller
{
    public $modelClass = 'app\models\Tweet';

    public function actionIndex()
    {
        $tweets = Tweet::find()->all();

        return $this->render('index', ['tweets' => $tweets]);
    }
}
