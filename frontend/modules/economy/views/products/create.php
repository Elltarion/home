<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\economy\models\Products */

$this->title = 'Добавить продукт';
$this->params['breadcrumbs'][] = ['label' => 'Продукты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'params' => $params,
    ]) ?>

</div>
