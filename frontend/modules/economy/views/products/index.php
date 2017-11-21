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
                    $sheckStart = false;
                    $unitShow = true;
                    $defaultColor = '#000';
                    $defaultColorNull = 'red';
                    $ranges = [];
                    $countRanges = count($model['countRanges']);

                    if($countRanges > 0) {
                        foreach($model['countRanges'] as $range) {
                            if(!$sheckStart && $range->pcr_type != 1 && $count > 0) {
                                $color = $range['type']->clt_color;
                                $sheckStart = true;
                            }

                            if($range->pcr_value <= $count) {
                                $color = $range['type']->clt_color;
                            }

                            $ranges[] = ['count' => $range->pcr_value, 'type' => $range->pcr_type, 'color' => $range['type']->clt_color];
                        }

                        if($countRanges == 1 && $model['countRanges'][0]->pcr_type == 1 && $count != 0) {
                            $color = $defaultColor;
                        }
                    } else {
                        if($count == 0) {
                            $color = $defaultColorNull;
                        } else {
                            $color = $defaultColor;
                        }
                    }

                    $unit = $model['unit']['ut_name_small'];
                    if($unit == '') {
                        $unit = 'шт.';
                    } else {
                        $unit .= '.';
                    }

                    if($count <= 0) {
                        $unitShow = false;
                        $count = 'Нет'; //при смене обязательно заменить data-null у эл-тов
                    }

                    $fieldHTML = Html::tag('div', '<span class="value" data-product="'.$model->product_id.'" data-null="Нет" data-defaultcolor="'.$defaultColor.'" data-defaultcolornull="'.$defaultColorNull.'" data-ranges="'.htmlspecialchars(json_encode($ranges), ENT_QUOTES, 'UTF-8').'">'.$count.'</span> <span class="unit '.($unitShow ? '' : 'hide').'">'.$unit.'</span>', ['class' => 'count', 'style' => ('color: '.$color.';')]);
                    $leftButtonHTML = Html::tag('div', '<span class="glyphicon glyphicon-minus"></span>', ['class' => 'btn minus btn-default']);
                    $rightButtonHTML = Html::tag('div', '<span class="glyphicon glyphicon-plus"></span>', ['class' => 'btn plus btn-default']);
                    return Html::tag('div', ($leftButtonHTML.$fieldHTML.$rightButtonHTML), ['class' => 'counter']);
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
