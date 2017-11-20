<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\economy\models\ProductsQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Продукты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить продукт', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php \yii\widgets\Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'beforeRow' => function($model, $key, $index, $el) {
            if($model['product_category'] != $el->separator) {
                $el->separator = $model['product_category'];
                return Html::tag('tr', Html::tag('td', $model['category']->category_name, ['colspan' => 6, 'style' => 'background-color: #fffcd1;']), []);
            }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'product_name',
            [
                'attribute' => 'category_name',
                'options' => ['width'=>'300px'],
                'value' => 'category.category_name',
            ],
            [
                'attribute' => 'product_count',
                'contentOptions' => ['class' => 'text-center'],
                'options' => ['width' => '100px'],
                'format' => 'raw',
                'value' => function ($model) {
                    $count = $model->product_count > 0 ? $model->product_count : 0;
                    $color = '';

                    if($count < 1) {
                        $color = 'red';
                    } else if($count < 2) {
                        $color = '#ca1414';
                    } else if($count < 3) {
                        $color = '#fba819';
                    } else if($count < 5) {
                        $color = '#acad00';
                    } else if($count >= 5) {
                        $color = '#5cb85c';
                    }

                    return Html::tag('span', $count, ['style' => ('color: '.$color.';')]);
                }
            ],

            ['class' => 'yii\grid\ActionColumn', 'contentOptions' => ['class' => 'text-center']],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>
