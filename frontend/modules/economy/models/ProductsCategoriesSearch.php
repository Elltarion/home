<?php

namespace app\modules\economy\models;

/**
 * This is the ActiveQuery class for [[ProductsCategories]].
 *
 * @see ProductsCategories
 */
class ProductsCategoriesSearch extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'category_sort'], 'integer'],
            [['category_name'], 'safe'],
        ];
    }
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ProductsCategories[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ProductsCategories|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @inheritdoc
     */
    public function getProducts()
    {

        return $this->hasMany(Products::className(), ['product_category' => 'category_id']);
    }
}
