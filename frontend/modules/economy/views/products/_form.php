<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\economy\models\ProductsCategories;
use app\modules\economy\models\EconomyUnitTypes;

/* @var $this yii\web\View */
/* @var $model app\modules\economy\models\Products */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'product_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'product_category')->dropDownList(ArrayHelper::map(ProductsCategories::find()->all(), 'category_id', 'category_name'),
        ['prompt'=>'Выберите...']) ?>

    <div class="form-group">
        <div class="col-sm-6 no-padding-left">
            <?= $form->field($model, 'product_count')->textInput() ?>
        </div>
        <div class="col-sm-6 no-padding-right">
            <div class="col-sm-6">
                <?= $form->field($model, 'product_count_unit')->dropDownList(ArrayHelper::map(EconomyUnitTypes::find()->all(), 'ut_id', 'ut_name'),
                    ['prompt'=>'Выберите...']) ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label" for="">Диапазоны количеств</label>
        <table id="countRanges" class="table table-striped table-bordered" style="width: 350px;">
            <tr>
                <th style="width: 100px;">Количество</th>
                <th>Статус</th>
                <th style="width: 57px;"></th>
            </tr>
        <?php
            /** @var array $usedTypes - использованные типы */
            $usedTypes = [];
            foreach($params['countRanges'] as $range) {
                $usedTypes[$range->pcr_type] = $range->pcr_type;
                echo '<tr class="item">';
                $disabled = '';
                if($range->pcr_type == 1) {
                    $disabled = 'readonly';
                }
                echo '<td><input class="form-control value" data-type="'.$range->pcr_type.'" data-weight="'.$range['type']->clt_weight.'" '.$disabled.' type="text" value="'.$range->pcr_value.'" name="count_ranges['.$range->pcr_type.'][pcr_value]"></td>';
                echo '<td class="va-center">
                            <input type="hidden" value="'.$range->pcr_type.'" name="count_ranges['.$range->pcr_type.'][pcr_type]">
                            <span style="color: '.$range['type']->clt_color.';">'.$range['type']->clt_name.'</span>
                        </td>';
                echo '<td>'.($disabled != '' ? '' : Html::tag('div', '<span class="glyphicon glyphicon-remove"></span>', ['class' => 'remove btn btn-danger fa fa-plus', 'title' => 'Удалить', 'data-type' => $range->pcr_type])).'</td>';
                echo '</tr>';
            }
        ?>
        <tr class="buttons">
            <td><input class="form-control" type="text" value="0" name="diapason_add_value"></td>
            <td>
                <select name="diapason_add_type" class="form-control">
                <?php
                    $hasSelected = false;
                    foreach($params['countRangeTypes'] as $type) {
                        $class = isset($usedTypes[$type->clt_id]) ? 'hide' : '';
                        $selected = '';
                        if(!$hasSelected && !isset($usedTypes[$type->clt_id])) {
                            $selected = 'selected';
                            $hasSelected = true;
                        }
                        echo '<option id="crt_option_'.$type->clt_id.'" value="'.$type->clt_id.'" '.$selected.' class="'.$class.'" style="color: '.$type->clt_color.'" data-weight="'.$type->clt_weight.'" data-color="'.$type->clt_color.'">'.$type->clt_name.'</option>';
                    }
                ?>
                </select>
            </td>
            <td align="center">
                <?= Html::tag('div', '<span class="glyphicon glyphicon-plus"></span>', ['id' => 'addCountRange', 'class' => 'btn btn-primary fa fa-plus', 'title' => 'Добавить'])?>
            </td>
        </tr>
        </table>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
