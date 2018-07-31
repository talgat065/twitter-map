<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Exception;

class Tweet extends ActiveRecord
{
    private $twitter;

    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $settings = [
            'oauth_access_token' => env('TWITTER_OAUTH_ACCESS_TOKEN'),
            'oauth_access_token_secret' => env('TWITTER_OAUTH_ACCESS_TOKEN_SECRET'),
            'consumer_key' => env('TWITTER_CONSUMER_KEY'),
            'consumer_secret' => env('TWITTER_CONSUMER_SECRET'),
        ];

        $this->twitter = new Twitter($settings);
    }

    /**
     * @throws \Exception
     */
    public function updateTweets()
    {
        $cityName = Yii::$app->getUser()->identity->accounts['twitter']->decodedData['location'];

        $locationData = $this->getGeoData($cityName);

        $lat = $locationData[1];

        $lon = $locationData[0];

        $tweets = $this->twitter->setLat($lat)
            ->setLon($lon)
            ->setRadius('50km')
            ->getTweets();

        return $this->saveTweets($tweets);
    }

    private function saveTweets($tweets)
    {
        $data = [];

        foreach ($tweets['statuses'] as $tweet) {
            $val = [
                'tweet_id' => $tweet['id_str'],
                'author' => '@'.$tweet['user']['screen_name'],
                'date' => date('Y-m-d H:i:s', strtotime($tweet['created_at'])),
                'body' => $tweet['text'],
                'lat' => $tweet['coordinates'][0] ?: 51.1801,
                'lng' => $tweet['coordinates'][1] ?: 71.44598,
            ];

            $data[] = $val;
        }
        try {
            Yii::$app->db->createCommand()
                ->batchInsert('tweet', ['tweet_id', 'author', 'date', 'body', 'lat', 'lng',], $data)
                ->execute();
        } catch (Exception $e) {
        }

        return $data;
    }

    /**
     * @param $cityName
     * @return mixed
     * @throws \Exception
     */
    public function getGeoData($cityName)
    {
        $data = $this->twitter->geoSearch($cityName);

        return $data['result']['places'][0]['centroid'];
    }
}
