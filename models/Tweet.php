<?php

namespace app\models;

use yii\db\ActiveRecord;

class Tweet extends ActiveRecord
{
    public static function tableName()
    {
        return '{{tweet}}';
    }
}
