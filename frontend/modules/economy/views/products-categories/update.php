<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\economy\models\ProductsCategories */

$this->title = 'Update Products Categories: ' . $model->category_id;
$this->params['breadcrumbs'][] = ['label' => 'Products Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->category_id, 'url' => ['view', 'id' => $model->category_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="products-categories-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
