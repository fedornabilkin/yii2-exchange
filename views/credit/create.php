<?php

use yii\helpers\Html;
use zxbodya\yii2\galleryManager\GalleryManager;


/* @var $this yii\web\View */
/* @var $model fedornabilkin\exchange\models\Exchange */

$this->title = Yii::t('exchange', 'Create Exchange');
$this->params['breadcrumbs'][] = ['label' => Yii::t('exchange', 'Exchanges'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exchange-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
