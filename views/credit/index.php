<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var $this yii\web\View
 * @var $dataProviderSale yii\data\ActiveDataProvider
 * @var $dataProviderBuy yii\data\ActiveDataProvider
 */

$this->title = Yii::t('exchange', 'All Exchange');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exchange-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('exchange', 'Create Exchange'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('exchange', 'My Exchange'), ['my'], ['class' => 'btn btn-primary']) ?>
    </p>

    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <h3><?= Yii::t('exchange', 'Sell credits')?></h3>
            <?= GridView::widget([
                'dataProvider' => $dataProviderSale,
                'layout'=>"{items}",
                'columns' => [
                    'id',
                    [
                        'label' => 'Цена за 1000',
                        'value' => function($data){
                            return 1000 * $data->amount / $data->credit;
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{sell}',
                        'buttons' => [
                            'sell' => function($url, $model){
                                return '<button class="btn ">' . $model->amount . '</button>';
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
        <div class="col-xs-12 col-sm-6">
            <h3><?= Yii::t('exchange', 'Buy credits')?></h3>
            <?= GridView::widget([
                'dataProvider' => $dataProviderBuy,
                'layout'=>"{items}",
                'columns' => [
                    'id',
                    [
                        'label' => 'Цена за 1000',
                        'value' => function($data){
                            return 1000 * $data->amount / $data->credit;
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{sell}',
                        'buttons' => [
                            'sell' => function($url, $model){
                                return '<button class="btn ">' . $model->amount . '</button>';
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
