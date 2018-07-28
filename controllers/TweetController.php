<?php

namespace app\controllers;

use yii\rest\ActiveController;
use app\models\Tweet;
use yii\web\Controller;

class TweetController extends Controller
{
    public $modelClass = 'app\models\Tweet';

    /**
     * @return string
     * @throws \Exception
     */
    public function actionIndex()
    {
        $tweet = new Tweet();
        $tweets = $tweet->findTweets();

        return $this->render('index', ['tweets' => $tweets]);
    }
}
