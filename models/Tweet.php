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
    public function updateTweets()
    {
        $cityName = Yii::$app->getUser()->identity->accounts['twitter']->decodedData['location'];

        $locationData = $this->getGeoData($cityName);

        $lat = $locationData[1];

        $lon = $locationData[0];

        $tweets = $this->twitter->setLat($lat)
            ->setLon($lon)
            ->setRadius('1000km')
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
            ];

            if (isset($tweet['coordinates'])) {
                $val['lat'] = $tweet['coordinates'][0];

                $val['lng'] = $tweet['coordinates'][1];
            }

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
