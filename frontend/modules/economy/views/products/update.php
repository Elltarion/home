<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\economy\models\Products */

$this->title = 'Редактировование продукта: ' . $model->product_name;
$this->params['breadcrumbs'][] = ['label' => 'Продукты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->product_name, 'url' => ['view', 'id' => $model->product_id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="products-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'params' => $params,
    ]) ?>

</div>
