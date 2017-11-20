<?php

namespace app\modules\economy\models;

/**
 * This is the ActiveQuery class for [[EconomyCountRangeTypes]].
 *
 * @see EconomyCountRangeTypes
 */
class EconomyCountRangeTypesSearch extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return EconomyCountRangeTypes[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return EconomyCountRangeTypes|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
