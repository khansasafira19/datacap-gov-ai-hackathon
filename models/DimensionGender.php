<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dimension_gender".
 *
 * @property int $id_dimension_gender
 * @property string $gender
 */
class DimensionGender extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dimension_gender';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gender'], 'required'],
            [['gender'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_dimension_gender' => 'Id Dimension Gender',
            'gender' => 'Gender',
        ];
    }
}
