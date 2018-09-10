<?php
/**
 * Created by PhpStorm.
 * User: smirnovrm
 * Date: 07.06.2018
 * Time: 16:32
 */

namespace fedornabilkin\exchange\interfaces;

/**
 * Interface ExchangeUserInterface
 * @package fedornabilkin\exchange\interfaces
 */
interface ExchangeUserInterface
{
    /**
     * Create or delete a requisition
     *
     * @param $credit
     * @param $amount
     * @param $type
     * @return mixed
     */
    public function creditAction($credit, $amount, $type);

    /**
     * Confirmation sell orders
     *
     * @param $credit
     * @param $amount
     * @return mixed
     */
    public function creditSale($credit, $amount);

    /**
     * Confirmation buy orders
     *
     * @param $credit
     * @param $amount
     * @return mixed
     */
    public function creditBuy($credit, $amount);
}