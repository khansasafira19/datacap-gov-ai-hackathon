<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dimension_agegroup".
 *
 * @property int $id_dimension_agegroup
 * @property string $agegroup
 * @property string $agegroup_en
 */
class DimensionAgegroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dimension_agegroup';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['agegroup', 'agegroup_en'], 'required'],
            [['agegroup', 'agegroup_en'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_dimension_agegroup' => 'Id Dimension Agegroup',
            'agegroup' => 'Agegroup',
            'agegroup_en' => 'Agegroup En',
        ];
    }
}
