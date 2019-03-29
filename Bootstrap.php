<?php

namespace fedornabilkin\exchange;

use dektrium\user\models\User;
use fedornabilkin\exchange\models\Exchange;
use Yii;
use yii\base\BootstrapInterface;
use yii\web\GroupUrlRule;

/**
 * Bootstrap class registers module and exchange application component. It also creates some url rules which will be applied
 * when UrlManager.enablePrettyUrl is enabled.
 */
class Bootstrap implements BootstrapInterface
{
    /** @var array Model's map */
    private $modelMap = [
        'Exchange' => Exchange::class,
        'User' => User::class,
    ];

    /** @inheritdoc */
    public function bootstrap($app)
    {
        /**
         * @var Module $module
         * @var \yii\db\ActiveRecord $modelName
         */
        $module = $app->getModule(Module::MODULE_NAME);

        if ($app->hasModule(Module::MODULE_NAME) && $module instanceof Module) {

            if ($module->moduleName != Module::MODULE_NAME) {
                $module->moduleName = Module::MODULE_NAME;
            }

            $this->modelMap = array_merge($this->modelMap, $module->modelMap);
            foreach ($this->modelMap as $name => $definition) {
                $class = "fedornabilkin\\exchange\\models\\" . $name;
                Yii::$container->set($class, $definition);
                $modelName = is_array($definition) ? $definition['class'] : $definition;
                $module->modelMap[$name] = $modelName;
            }

            Yii::$container->set('yii\web\User', [
                'identityClass' => $module->modelMap['User'],
            ]);

            $configUrlRule = [
                'prefix' => ($module->urlPrefix != $module->moduleName) ? $module->moduleName : $module->urlPrefix,
                'rules'  => $module->urlRules,
            ];

            $configUrlRule['class'] = GroupUrlRule::class;
            $rule = Yii::createObject($configUrlRule);

            $app->urlManager->addRules([$rule], false);



            $module->debug = $this->ensureCorrectDebugSetting();
        }
    }

    /** Ensure the module is not in DEBUG mode on production environments */
    public function ensureCorrectDebugSetting()
    {
        if (!defined('YII_DEBUG')) {
            return false;
        }
        if (!defined('YII_ENV')) {
            return false;
        }
        if (defined('YII_ENV') && YII_ENV !== 'dev') {
            return false;
        }
        if (defined('YII_DEBUG') && YII_DEBUG !== true) {
            return false;
        }

        return Yii::$app->getModule('exchange')->debug;
    }
}
