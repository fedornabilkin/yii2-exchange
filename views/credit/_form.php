<?php
/*
 * @var $this yii\web\View
 * @var $model fedornabilkin\exchange\models\Exchange
 * @var $form yii\widgets\ActiveForm
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

if (!$model->type) {
    $model->type = $model::EXCHANGE_CREDIT_BUY;
}
?>

<div class="exchange-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->radioList([
        $model::EXCHANGE_CREDIT_BUY => $model::EXCHANGE_CREDIT_BUY,
        $model::EXCHANGE_CREDIT_SALE => $model::EXCHANGE_CREDIT_SALE,
    ]) ?>

    <?= $form->field($model, 'credit')->textInput() ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'count')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('exchange', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
