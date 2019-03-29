<?php

namespace fedornabilkin\exchange\controllers;

use fedornabilkin\exchange\Finder;
use fedornabilkin\exchange\Module;
use Yii;
use fedornabilkin\exchange\models\Exchange;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CreditController implements the CRUD actions for Exchange model.
 *
 * @property Module $module
 */
class CreditController extends Controller
{

    /** @var Finder */
    protected $finder;

    /**
     * @param string           $id
     * @param \yii\base\Module $module
     * @param Finder           $finder
     * @param array            $config
     */
    public function __construct($id, $module, Finder $finder, $config = [])
    {
        $this->finder = $finder;
        parent::__construct($id, $module, $config);
    }
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Exchange models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProviderSale = new ActiveDataProvider([
            'query' => Exchange::find()
                ->select('*, (1000 * amount / credit) AS price')
                ->where(['type' => Exchange::EXCHANGE_CREDIT_SALE])
                ->orderBy(['price' => SORT_DESC])
                ->limit(100),
        ]);

        $dataProviderBuy = new ActiveDataProvider([
            'query' => Exchange::find()
                ->select('*, (1000 * amount / credit) AS price')
                ->where(['type' => Exchange::EXCHANGE_CREDIT_BUY])
                ->orderBy(['price' => SORT_ASC])
                ->limit(100),
        ]);

        return $this->render('index', [
            'dataProviderSale' => $dataProviderSale,
            'dataProviderBuy' => $dataProviderBuy,
        ]);
    }

    /**
     * Displays a single Exchange model.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionMy()
    {
        $dataProviderSale = new ActiveDataProvider([
            'query' => Exchange::find()->where(['type' => Exchange::EXCHANGE_CREDIT_SALE]),
        ]);

        $dataProviderBuy = new ActiveDataProvider([
            'query' => Exchange::find()->where(['type' => Exchange::EXCHANGE_CREDIT_BUY]),
        ]);

        return $this->render('my', [
            'dataProviderSale' => $dataProviderSale,
            'dataProviderBuy' => $dataProviderBuy,
        ]);
    }

    /**
     * Creates a new Exchange model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = Yii::createObject(['class' => $this->module->modelMap['Exchange']]);

        $model->user_id = 1;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['my']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Exchange model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['my']);
    }

    /**
     * Finds the Exchange model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Exchange the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Exchange::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('exchange', 'The requested page does not exist.'));
    }

    protected function beforeInsert($model){
        \Yii::$app->session->setFlash('success', 'before event');
//        var_dump($model);exit;
    }
    protected function afterInsert($model){}
    protected function beforeUpdate($model){}
    protected function afterUpdate($model){}
    protected function beforeDelete($model){}
    protected function afterDelete($model){}
}
