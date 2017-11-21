<?php

namespace app\modules\economy\models;

use Yii;

/**
 * This is the model class for table "economy_product_count_ranges".
 *
 * @property integer $pcr_id
 * @property integer $pcr_product
 * @property integer $pcr_type
 * @property integer $pcr_value
 */
class EconomyProductCountRanges extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'economy_product_count_ranges';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pcr_product', 'pcr_type', 'pcr_value'], 'required'],
            [['pcr_product', 'pcr_type'], 'integer'],
            [['pcr_value'], 'double'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pcr_id' => 'Pcr ID',
            'pcr_product' => 'Pcr Product',
            'pcr_type' => 'Pcr Type',
            'pcr_value' => 'Pcr Value',
        ];
    }

    /**
     * @inheritdoc
     * @return EconomyProductCountRangesSearch the active query used by this AR class.
     */
    public static function find()
    {
        return new EconomyProductCountRangesSearch(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return $this->hasOne(EconomyCountRangeTypes::className(), ['clt_id' => 'pcr_type']);
    }
}
