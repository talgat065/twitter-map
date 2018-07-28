<?php

namespace app\models;

use TwitterAPIExchange;

class Twitter
{
    private $twitterApi;
    private $url;
    private $method;
    private $lat;
    private $lon;
    private $radius;

    public function __construct($settings)
    {
        $this->method = 'GET';
        $this->url = 'https://api.twitter.com/1.1/search/tweets.json';
        $this->twitterApi = new TwitterAPIExchange($settings);
    }

    /**
     * @param mixed $lat
     * @return \app\models\Twitter
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param mixed $lon
     * @return \app\models\Twitter
     */
    public function setLon($lon)
    {
        $this->lon = $lon;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLon()
    {
        return $this->lon;
    }

    /**
     * @param mixed $radius
     */
    public function setRadius($radius)
    {
        $this->radius = $radius;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRadius()
    {
        return $this->radius;
    }

    /**
     * @throws \Exception
     */
    public function getTweets()
    {
        $getField = "?geocode={$this->getLat()},{$this->getLon()},{$this->getRadius()}";

        $result = $this->twitterApi->setGetfield($getField)
            ->buildOauth($this->url, $this->method)
            ->performRequest();

        return json_decode($result, true);
    }
}
