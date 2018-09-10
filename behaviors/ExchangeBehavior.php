<?php
/**
 * Created by PhpStorm.
 * User: smirnovrm
 * Date: 08.06.2018
 * Time: 12:25
 */

namespace fedornabilkin\exchange\behaviors;


use yii\base\Behavior;
use yii\db\ActiveRecord;

class ExchangeBehavior extends Behavior
{

    /** @return array */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
        ];
    }

    public function beforeInsert() {
        $model = $this->owner;

    }

    public function getUser()
    {
        return \Yii::$app->user;
    }
}