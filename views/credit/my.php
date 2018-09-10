<?php

use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $dataProviderSale yii\data\ActiveDataProvider
 * @var $dataProviderBuy yii\data\ActiveDataProvider
 */

$this->title = Yii::t('exchange', 'My Exchange');
$this->params['breadcrumbs'][] = ['label' => Yii::t('exchange', 'All Exchange'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exchange-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('exchange', 'Create Exchange'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('exchange', 'All Exchange'), ['index'], ['class' => 'btn btn-primary']) ?>
    </p>

    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <h3><?= Yii::t('exchange', 'My sales requests')?></h3>
            <?= GridView::widget([
                'dataProvider' => $dataProviderSale,
                'layout'=>"{items}",
                'columns' => [
//                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'credit',
                    'amount',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{delete}'
                    ],
                ],
            ]); ?>
        </div>
        <div class="col-xs-12 col-sm-6">
            <h3><?= Yii::t('exchange', 'My purchase requests')?></h3>
            <?= GridView::widget([
                'dataProvider' => $dataProviderBuy,
                'layout'=>"{items}",
                'columns' => [
//                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'credit',
                    'amount',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{delete}'
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
