<?php

namespace app\models;

use yii\db\ActiveRecord;

class Tweet extends ActiveRecord
{
    private $twitter;

    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $settings = [
            'oauth_access_token' => "2493387068-LmLDx7jQ6AWzsXLshCGbwI1p92NuRZChrVZrLjH",
            'oauth_access_token_secret' => "M6abr3iI8piCQxKIXZ9unsZAxhniVNFxSuB8ihFPpBfih",
            'consumer_key' => "TcIaMjcTrK0w2MXR4s39bG327",
            'consumer_secret' => "ZyNrWvT19FWwIzKm8BPAsVgQ73yqvrP8lpyjv1qnmM5YV1Ngfo",
        ];
        $this->twitter = new Twitter($settings);
    }

    /**
     * @throws \Exception
     */
    public function findTweets()
    {
        return $this->twitter->setLat('51.1801')
            ->setLon('71.44598')
            ->setRadius('100km')
            ->getTweets();
    }
}
