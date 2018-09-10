<?php

namespace fedornabilkin\exchange\models;

use fedornabilkin\exchange\Module;
use Yii;
use yii\behaviors\TimestampBehavior;
use zxbodya\yii2\galleryManager\GalleryBehavior;

/**
 * This is the model class for table "{{%exchange}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property double $credit
 * @property double $amount
 * @property int $updated_at
 * @property int $created_at
 */
class Exchange extends \yii\db\ActiveRecord
{
    CONST EXCHANGE_CREDIT_SALE = 'sale';
    CONST EXCHANGE_CREDIT_BUY = 'buy';
    CONST EXCHANGE_CREDIT_DELETE = 'delete';

    /**
     * @var \fedornabilkin\exchange\Module
     */
    protected $module;

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
                'class' => TimestampBehavior::class,
            ],
        ]);
    }

    public function beforeSave($insert)
    {
        $module = $this->module;
        var_dump(Yii::$app->user->identity->getId());exit;
        var_dump($module->modelMap['User']);exit;

        return parent::beforeSave($insert);
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
            [['user_id', 'updated_at', 'created_at'], 'integer'],
            [['credit', 'amount'], 'number'],
            [['credit', 'amount'], 'required'],
            [['type'], 'string', 'max' => 50],
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
            'updated_at' => Yii::t('exchange', 'Updated At'),
            'created_at' => Yii::t('exchange', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne($this->module->modelMap['User'], ['id' => 'user_id']);
    }
}
