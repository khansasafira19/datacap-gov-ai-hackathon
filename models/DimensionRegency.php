<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dimension_regency".
 *
 * @property int $id_dimension_regency
 * @property string $fk_dimension_province
 * @property string $regency_name
 * @property string $regency_name_en
 */
class DimensionRegency extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dimension_regency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_dimension_province', 'regency_name', 'regency_name_en'], 'required'],
            [['fk_dimension_province'], 'string', 'max' => 2],
            [['regency_name', 'regency_name_en'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_dimension_regency' => 'Id Dimension Regency',
            'fk_dimension_province' => 'Fk Dimension Province',
            'regency_name' => 'Regency Name',
            'regency_name_en' => 'Regency Name En',
        ];
    }
}
