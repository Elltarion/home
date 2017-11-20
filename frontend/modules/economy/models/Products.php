<?php

namespace app\modules\economy\models;
use app\modules\economy\models\ProductsCategories;
use Yii;

/**
 * This is the model class for table "economy_products".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $category
 * @property integer $count
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'economy_products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_name'], 'required'],
            [['product_category', 'product_count_unit'], 'integer'],
            [['product_count'], 'double'],
            [['product_name', 'product_description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'ID',
            'product_name' => 'Название',
            'product_description' => 'Описание',
            'product_category' => 'Категория',
            'category.category_name' => 'Категория',
            'category_name' => 'Категория',
            'product_count' => 'Наличие',
            'product_count_unit' => 'Ед. измерения',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getCategory()
    {

        return $this->hasOne(ProductsCategories::className(), ['category_id' => 'product_category']);
    }

    /**
     * @inheritdoc
     */
    public function getUnit()
    {

        return $this->hasOne(EconomyUnitTypes::className(), ['ut_id' => 'product_count_unit']);
    }

    /**
     * @inheritdoc
     */
    public function getCountRanges()
    {
        return $this->hasMany(EconomyProductCountRanges::className(), ['pcr_product' => 'product_id'])->joinWith('type')->orderBy('clt_weight', SORT_ASC);
    }
}
