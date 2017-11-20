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
        <?= Html::a('Добавить продукт', ['create'], ['class' => 'btn btn-success btn-create']) ?>
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

                    if(count($model['countRanges']) > 0) {
                        foreach($model['countRanges'] as $range) {
                            if($range->pcr_value <= $count) {
                                $color = $range['type']->clt_color;
                            }
                        }
                    } else {
                        if($count == 0) {
                            $color = 'red';
                        } else {
                            $color = '#000';
                        }
                    }

                    if($count > 0) {
                        $unit = $model['unit']['ut_name_small'];
                        if($unit == '') {
                            $unit = 'шт';
                        }
                        $count = $count .' '. $unit . '.';
                    }

                    return Html::tag('span', $count, ['style' => ('color: '.$color.';')]);
                }
            ],

            ['class' => 'yii\grid\ActionColumn', 'contentOptions' => ['class' => 'text-center'], 'template'=>'{update}  {delete}',
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        $customurl = Yii::$app->getUrlManager()->createUrl(['/economy/products/update', 'id' => $model['product_id']]);
                        //открываем в новой вкладке
                        return \yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil"></span>', $customurl,
                            ['title' => Yii::t('yii', 'Редактировать'), 'data-pjax' => '0', 'target' => '_blank']);
                    },
                    'delete'=>function ($url, $model) {
                        $customurl = Yii::$app->getUrlManager()->createUrl(['/economy/products/delete', 'id' => $model['product_id']]);
                        //открываем в новой вкладке
                        return \yii\helpers\Html::a('<span class="glyphicon glyphicon-trash"></span>', $customurl,
                            ['title' => Yii::t('yii', 'Удалить'), 'data-confirm' => 'Удалить продукт?', 'data-method' => 'post', 'data-pjax' => '1']);
                    }
                ],
            ],
        ]
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>
