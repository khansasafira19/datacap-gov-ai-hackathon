<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dimension_unit".
 *
 * @property int $id_dimension_unit
 * @property string $unit
 * @property string $unit_en
 */
class DimensionUnit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dimension_unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit', 'unit_en'], 'required'],
            [['unit', 'unit_en'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_dimension_unit' => 'Id Dimension Unit',
            'unit' => 'Unit',
            'unit_en' => 'Unit En',
        ];
    }
}
