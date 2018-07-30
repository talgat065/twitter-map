<?php

namespace app\controllers;

use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use app\models\Tweet;

class TweetController extends ActiveController
{
    public $modelClass = 'app\models\Tweet';

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'corsFilter' => [
                'class' => Cors::className(),
            ],
        ]);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionIndex()
    {
        return $this->render('index', ['tweets' => Tweet::find()->all()]);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionUpdate()
    {
        $model = new Tweet();

        $model->updateTweets();

        return 'success';
    }
}
