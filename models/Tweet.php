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
            'oauth_access_token' => "2493387068-LmLDx7jQ6AWzsXLshCGbwI1p92NuRZChrVZrLjH", 'oauth_access_token_secret' => "M6abr3iI8piCQxKIXZ9unsZAxhniVNFxSuB8ihFPpBfih", 'consumer_key' => "TcIaMjcTrK0w2MXR4s39bG327", 'consumer_secret' => "ZyNrWvT19FWwIzKm8BPAsVgQ73yqvrP8lpyjv1qnmM5YV1Ngfo",
        ];
        $this->twitter = new Twitter($settings);
    }

    /**
     * @throws \Exception
     */
    public function findTweets()
    {
        $tweets = $this->twitter->setLat('51.509865')
            ->setLon('-0.118092')
            ->setRadius('10km')
            ->getTweets();

        return $this->saveTweets($tweets);
        //return $tweets;
    }

    private function saveTweets($tweets)
    {
        $data = [];

        foreach ($tweets['statuses'] as $tweet) {
            if (isset($tweet['geo']['coordinates'])) {
                $val['tweet_id'] = $tweet['id_str'];

                $val['author'] = '@'.$tweet['user']['screen_name'];

                $val['date'] = date('Y-m-d H:i:s', strtotime($tweet['created_at']));

                $val['body'] = $tweet['text'];

                $val['lat'] = $tweet['geo']['coordinates'][0];

                $val['lng'] = $tweet['geo']['coordinates'][1];

                $data[] = $val;
            }
        }

        try {
            Yii::$app->db->createCommand()
                ->batchInsert('tweet', [
                    'tweet_id', 'author', 'date', 'body', 'lat', 'lng',
                ], $data)
                ->execute();
        } catch (Exception $e) {

        }

        return $data;
    }
}
