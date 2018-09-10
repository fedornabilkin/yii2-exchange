<?php
/**
 * Created by PhpStorm.
 * User: smirnovrm
 * Date: 31.05.2018
 * Time: 17:16
 */

namespace fedornabilkin\exchange;


use yii\i18n\PhpMessageSource;

class Module extends \yii\base\Module
{
    CONST MODULE_VERSION = '0.0.1';
    CONST MODULE_NAME = 'exchange';

    public $moduleName;

    /** @var array Model map */
    public $modelMap = [];

    /**
     * @var string The prefix for exchange module URL.
     *
     * @See [[GroupUrlRule::prefix]]
     */
    public $urlPrefix = 'exchange';

    /**
     * @var bool Is the exchange module in DEBUG mode? Will be set to false automatically
     * if the application leaves DEBUG mode.
     */
    public $debug = false;


    /** @var string The database connection to use for models in this module. */
    public $dbConnection = 'db';

    /** @var array The rules to be used in URL management. */
    public $urlRules = [
        'credit/delete/<id:\d+>'    => 'credit/delete',
        'credit/<action:\w+>'       => 'credit/<action>',
    ];


    public function init() {
        parent::init();

        $this->moduleName = self::MODULE_NAME;

        if (!isset(\Yii::$app->i18n->translations[$this->moduleName . '*'])) {
            \Yii::$app->i18n->translations[$this->moduleName . '*'] = [
                'class' => PhpMessageSource::class,
                'sourceLanguage' => 'ru',
                'basePath' => __DIR__ . '/messages',
            ];
        }
    }

    /**
     * @return string
     */
    public function getDb()
    {
        return \Yii::$app->get($this->dbConnection);
    }
}