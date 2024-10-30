<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dimension_province".
 *
 * @property string $id_dimension_province
 * @property string $province_name
 * @property string $province_name_en
 * @property string $province_highchart_code
 */
class DimensionProvince extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dimension_province';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_dimension_province', 'province_name', 'province_name_en', 'province_highchart_code'], 'required'],
            [['id_dimension_province'], 'string', 'max' => 2],
            [['province_name', 'province_name_en'], 'string', 'max' => 255],
            [['province_highchart_code'], 'string', 'max' => 5],
            [['id_dimension_province'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_dimension_province' => 'Id Dimension Province',
            'province_name' => 'Province Name',
            'province_name_en' => 'Province Name En',
            'province_highchart_code' => 'Province Highchart Code',
        ];
    }
}
