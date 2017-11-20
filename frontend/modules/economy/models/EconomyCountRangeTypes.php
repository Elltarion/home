<?php

namespace app\modules\economy\models;

use Yii;

/**
 * This is the model class for table "economy_count_range_types".
 *
 * @property integer $clt_id
 * @property string $clt_name
 * @property string $clt_color
 * @property string %clt_weight
 */
class EconomyCountRangeTypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'economy_count_range_types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['clt_name', 'clt_color'], 'required'],
            [['clt_name', 'clt_color'], 'string', 'max' => 255],
            [['clt_weight'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'clt_id' => 'Clt ID',
            'clt_name' => 'Clt Name',
            'clt_color' => 'Clt Color',
            'clt_weight' => 'Clt Weight',
        ];
    }

    /**
     * @inheritdoc
     * @return EconomyCountRangeTypesSearch the active query used by this AR class.
     */
    public static function find()
    {
        return new EconomyCountRangeTypesSearch(get_called_class());
    }
}
