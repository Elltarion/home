<?php

namespace app\modules\economy\models;

/**
 * This is the ActiveQuery class for [[EconomyUnitTypes]].
 *
 * @see EconomyUnitTypes
 */
class EconomyUnitTypesSearch extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return EconomyUnitTypes[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return EconomyUnitTypes|array|null
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

        return $this->hasMany(Products::className(), ['product_count_unit' => 'ut_id']);
    }
}
