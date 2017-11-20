<?php

namespace app\modules\economy\models;

/**
 * This is the ActiveQuery class for [[EconomyProductCountRanges]].
 *
 * @see EconomyProductCountRanges
 */
class EconomyProductCountRangesSearch extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return EconomyProductCountRanges[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return EconomyProductCountRanges|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
