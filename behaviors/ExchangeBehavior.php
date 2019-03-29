<?php
/**
 * Created by PhpStorm.
 * User: smirnovrm
 * Date: 08.06.2018
 * Time: 12:25
 */

namespace fedornabilkin\exchange\behaviors;


use fedornabilkin\exchange\models\Exchange;
use yii\base\Behavior;

class ExchangeBehavior extends Behavior
{
    /** @var  Exchange */
    protected $model;

    /** @return array */
    public function events()
    {
        $this->setModel();

        return [
            Exchange::EVENT_EXCHANGE_BEFORE_ADD_BUY => [$this->model, 'beforeInsertBuy'],
            Exchange::EVENT_EXCHANGE_AFTER_ADD_BUY => [$this->model, 'afterInsertBuy'],
            Exchange::EVENT_EXCHANGE_BEFORE_ADD_SALE => [$this->model, 'beforeInsertSale'],
            Exchange::EVENT_EXCHANGE_AFTER_ADD_SALE => [$this->model, 'afterInsertSale'],

            Exchange::EVENT_EXCHANGE_BEFORE_BUY => [$this->model, 'beforeUpdateBuy'],
            Exchange::EVENT_EXCHANGE_AFTER_BUY => [$this->model, 'afterUpdateBuy'],
            Exchange::EVENT_EXCHANGE_BEFORE_SALE => [$this->model, 'beforeUpdateSale'],
            Exchange::EVENT_EXCHANGE_AFTER_SALE => [$this->model, 'afterUpdateSale'],

            Exchange::EVENT_EXCHANGE_BEFORE_DELETE_BUY => [$this->model, 'beforeDeleteBuy'],
            Exchange::EVENT_EXCHANGE_AFTER_DELETE_BUY => [$this->model, 'afterDeleteBuy'],
            Exchange::EVENT_EXCHANGE_BEFORE_DELETE_SALE => [$this->model, 'beforeDeleteSale'],
            Exchange::EVENT_EXCHANGE_AFTER_DELETE_SALE => [$this->model, 'afterDeleteSale'],
        ];
    }

    protected function setModel()
    {
        $this->model = $this->owner;
    }
}
