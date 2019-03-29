<?php
/**
 * Created by PhpStorm.
 * User: smirnovrm
 * Date: 29.03.2019
 * Time: 15:59
 */

namespace fedornabilkin\exchange\interfaces;


interface IExchangeModel
{
    public function beforeInsertBuy();
    public function afterInsertBuy();
    public function beforeInsertSale();
    public function afterInsertSale();

    public function beforeUpdateBuy();
    public function afterUpdateBuy();
    public function beforeUpdateSale();
    public function afterUpdateSale();

    public function beforeDeleteBuy();
    public function afterDeleteBuy();
    public function beforeDeleteSale();
    public function afterDeleteSale();
}
