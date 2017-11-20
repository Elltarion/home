<?php

namespace app\modules\economy\models;

use Yii;

/**
 * This is the model class for table "economy_products_categories".
 *
 * @property integer $id
 * @property string $name
 * @property integer $sort
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
     * @return ProductsCategoriesSearch the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductsCategoriesSearch(get_called_class());
    }
}
