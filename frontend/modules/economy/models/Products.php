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
            [['product_category', 'count'], 'integer'],
            [['product_name', 'description'], 'string', 'max' => 255],
            [['category_name', ], 'safe'],
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
            'product_count' => 'Количество',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getCategory()
    {

        return $this->hasOne(ProductsCategories::className(), ['category_id' => 'product_category']);
    }

}
