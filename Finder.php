<?php
/**
 * Created by PhpStorm.
 * User: smirnovrm
 * Date: 27.06.2018
 * Time: 15:40
 */

namespace fedornabilkin\exchange;


use yii\base\BaseObject;
use yii\db\ActiveQuery;

class Finder extends BaseObject
{
    /** @var ActiveQuery */
    protected $exchangeQuery;
}