<?php

namespace fedornabilkin\exchange\models;

use fedornabilkin\exchange\behaviors\ExchangeBehavior;
use fedornabilkin\exchange\events\ExchangeEvent;
use fedornabilkin\exchange\Module;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%exchange}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property double $credit
 * @property double $amount
 * @property int $count
 * @property int $updated_at
 * @property int $created_at
 */
class Exchange extends \yii\db\ActiveRecord
{
    public $count = 1;
    public $credit = 50;

    CONST EXCHANGE_CREDIT_SALE = 'sale';
    CONST EXCHANGE_CREDIT_BUY = 'buy';
    CONST EXCHANGE_CREDIT_DELETE = 'delete';

    // create model
    CONST EVENT_EXCHANGE_BEFORE_ADD_SALE = 'event_exchange_before_add_sale';
    CONST EVENT_EXCHANGE_AFTER_ADD_SALE = 'event_exchange_after_add_sale';
    CONST EVENT_EXCHANGE_BEFORE_ADD_BUY = 'event_exchange_before_add_buy';
    CONST EVENT_EXCHANGE_AFTER_ADD_BUY = 'event_exchange_after_add_buy';

    // update model
    CONST EVENT_EXCHANGE_BEFORE_SALE = 'event_exchange_before_sale';
    CONST EVENT_EXCHANGE_AFTER_SALE = 'event_exchange_after_sale';
    CONST EVENT_EXCHANGE_BEFORE_BUY = 'event_exchange_before_buy';
    CONST EVENT_EXCHANGE_AFTER_BUY = 'event_exchange_after_buy';

    // delete model
    CONST EVENT_EXCHANGE_BEFORE_DELETE_BUY = 'event_exchange_before_delete_buy';
    CONST EVENT_EXCHANGE_AFTER_DELETE_BUY = 'event_exchange_after_delete_buy';
    CONST EVENT_EXCHANGE_BEFORE_DELETE_SALE = 'event_exchange_before_delete_sale';
    CONST EVENT_EXCHANGE_AFTER_DELETE_SALE = 'event_exchange_after_delete_sale';

    /**
     * @var \fedornabilkin\exchange\Module
     */
    public $module;

    /** @inheritdoc */
    public function init()
    {
        $this->module = \Yii::$app->getModule(Module::MODULE_NAME);
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return array_merge_recursive(parent::behaviors(), [
            'TimestampBehavior' => [
                'class' => TimestampBehavior::class
            ],
            'ExchangeBehavior' => [
                'class' => ExchangeBehavior::class
            ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%exchange}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            'countInteger' => [['count'], 'integer'],
            'creditAmountNumber' => [['credit', 'amount'], 'number'],
            'creditAmountRequired' => [['credit', 'amount'], 'required'],
            'typeString' => [['type'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => $this->module->modelMap['User'], 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('exchange', 'ID'),
            'user_id' => Yii::t('exchange', 'User ID'),
            'type' => Yii::t('exchange', 'Type'),
            'credit' => Yii::t('exchange', 'Credit'),
            'amount' => Yii::t('exchange', 'Amount'),
            'count' => Yii::t('exchange', 'Count'),
            'updated_at' => Yii::t('exchange', 'Updated At'),
            'created_at' => Yii::t('exchange', 'Created At'),
        ];
    }

    public function beforeInsertBuy(){}
    public function afterInsertBuy(){}
    public function beforeInsertSale(){}
    public function afterInsertSale(){}

    public function beforeUpdateBuy(){}
    public function afterUpdateBuy(){}
    public function beforeUpdateSale(){}
    public function afterUpdateSale(){}

    public function beforeDeleteBuy(){}
    public function afterDeleteBuy(){}
    public function beforeDeleteSale(){}
    public function afterDeleteSale(){}

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $typeEvent = $insert ? 'insert': 'update';
        $nameEvent = $this->getNameEvent('before', $typeEvent, $this->type);
        $this->setTrigger($nameEvent, $this->getExchangeEvent());

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $typeEvent = $insert ? 'insert': 'update';
        $nameEvent = $this->getNameEvent('after', $typeEvent, $this->type);
        $this->setTrigger($nameEvent, $this->getExchangeEvent());
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        $nameEvent = $this->getNameEvent('before', 'delete', $this->type);
        $this->setTrigger($nameEvent, $this->getExchangeEvent());

        return parent::beforeDelete();
    }

    public function afterDelete()
    {
        parent::afterDelete();

        $nameEvent = $this->getNameEvent('after', 'delete', $this->type);
        $this->setTrigger($nameEvent, $this->getExchangeEvent());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne($this->module->modelMap['User'], ['id' => 'user_id']);
    }

    /**
     * @return ExchangeEvent
     */
    protected function getExchangeEvent()
    {
        return new ExchangeEvent(['model' => $this]);
    }

    /**
     * @param string $name
     * @param null $data
     */
    protected function setTrigger($name, $data = null)
    {
        $this->trigger($name, $data);
    }

    /**
     * @param $timeEvent string
     * @param $typeEvent string
     * @param $type string
     * @return string
     */
    protected function getNameEvent($timeEvent, $typeEvent, $type)
    {
        $events = [
            'before' => [
                'delete' => [
                    self::EXCHANGE_CREDIT_SALE => self::EVENT_EXCHANGE_BEFORE_DELETE_SALE,
                    self::EXCHANGE_CREDIT_BUY => self::EVENT_EXCHANGE_BEFORE_DELETE_BUY
                ],
                'insert' => [
                    self::EXCHANGE_CREDIT_SALE => self::EVENT_EXCHANGE_BEFORE_ADD_SALE,
                    self::EXCHANGE_CREDIT_BUY => self::EVENT_EXCHANGE_BEFORE_ADD_BUY
                ],
                'update' => [
                    self::EXCHANGE_CREDIT_SALE => self::EVENT_EXCHANGE_BEFORE_SALE,
                    self::EXCHANGE_CREDIT_BUY => self::EVENT_EXCHANGE_BEFORE_BUY
                ],
            ],
            'after' => [
                'delete' => [
                    self::EXCHANGE_CREDIT_SALE => self::EVENT_EXCHANGE_AFTER_DELETE_SALE,
                    self::EXCHANGE_CREDIT_BUY => self::EVENT_EXCHANGE_AFTER_DELETE_BUY
                ],
                'insert' => [
                    self::EXCHANGE_CREDIT_SALE => self::EVENT_EXCHANGE_AFTER_ADD_SALE,
                    self::EXCHANGE_CREDIT_BUY => self::EVENT_EXCHANGE_AFTER_ADD_BUY
                ],
                'update' => [
                    self::EXCHANGE_CREDIT_SALE => self::EVENT_EXCHANGE_AFTER_SALE,
                    self::EXCHANGE_CREDIT_BUY => self::EVENT_EXCHANGE_AFTER_BUY
                ],
            ]
        ];

        return $events[$timeEvent][$typeEvent][$type];
    }

    protected function getUserIdentity()
    {
        return \Yii::$app->user;
    }
}
