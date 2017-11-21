<?php

namespace app\modules\economy\models;
use app\modules\economy\models\Products;

use Yii;

/**
 * This is the model class for table "economy_products_categories".
 *
 * @property integer $category_id
 * @property string $category_name
 * @property integer $category_sort
 */
class ProductsCategories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'economy_products_categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_name'], 'required'],
            [['category_sort'], 'integer'],
            [['category_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'ID',
            'category_name' => 'Название',
            'category_sort' => 'Сортировка',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['product_category' => 'category_id']);
    }
}
