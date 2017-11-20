<?php

namespace app\modules\economy\models;

use Yii;

/**
 * This is the model class for table "economy_unit_types".
 *
 * @property integer $ut_id
 * @property string $ut_name
 * @property string $ut_name_small
 */
class EconomyUnitTypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'economy_unit_types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ut_name', 'ut_name_small'], 'required'],
            [['ut_name', 'ut_name_small'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ut_id' => 'ID',
            'ut_name' => 'Название',
            'ut_name_small' => 'Сокращение',
        ];
    }

    /**
     * @inheritdoc
     * @return EconomyUnitTypesSearch the active query used by this AR class.
     */
    public static function find()
    {
        return new EconomyUnitTypesSearch(get_called_class());
    }
}
