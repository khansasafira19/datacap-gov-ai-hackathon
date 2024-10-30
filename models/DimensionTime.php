<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dimension_time".
 *
 * @property int $id_dimension_time
 * @property string|null $year_range
 * @property int $year
 * @property int|null $semester
 * @property int|null $quarter
 * @property int|null $month
 */
class DimensionTime extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dimension_time';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year'], 'required'],
            [['year', 'semester', 'quarter', 'month'], 'integer'],
            [['year_range'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_dimension_time' => 'Id Dimension Time',
            'year_range' => 'Year Range',
            'year' => 'Year',
            'semester' => 'Semester',
            'quarter' => 'Quarter',
            'month' => 'Month',
        ];
    }
}
