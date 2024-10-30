<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dimension_areatype".
 *
 * @property int $id_dimension_areatype
 * @property string $areatype
 */
class DimensionAreatype extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dimension_areatype';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['areatype'], 'required'],
            [['areatype'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_dimension_areatype' => 'Id Dimension Areatype',
            'areatype' => 'Areatype',
        ];
    }
}
