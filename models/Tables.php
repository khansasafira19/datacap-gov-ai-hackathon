<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tables".
 *
 * @property int $id_table
 * @property int|null $fk_dimension_agegroup
 * @property int|null $fk_dimension_areatype
 * @property int|null $fk_dimension_gender
 * @property string|null $fk_dimension_province
 * @property int|null $fk_dimension_regency
 * @property int $fk_dimension_time
 * @property int $fk_dimension_title
 * @property int $fk_dimension_unit
 * @property float|null $tables_value
 * @property int|null $deleted
 * @property string|null $timestamp
 * @property string|null $timestamp_lastupdate
 */
class Tables extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tables';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_dimension_agegroup', 'fk_dimension_areatype', 'fk_dimension_gender', 'fk_dimension_regency', 'fk_dimension_time', 'fk_dimension_title', 'fk_dimension_unit', 'deleted'], 'integer'],
            [['fk_dimension_time', 'fk_dimension_title', 'fk_dimension_unit'], 'required'],
            [['tables_value'], 'number'],
            [['timestamp', 'timestamp_lastupdate'], 'safe'],
            [['fk_dimension_province'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_table' => 'Id Table',
            'fk_dimension_agegroup' => 'Fk Dimension Agegroup',
            'fk_dimension_areatype' => 'Fk Dimension Areatype',
            'fk_dimension_gender' => 'Fk Dimension Gender',
            'fk_dimension_province' => 'Fk Dimension Province',
            'fk_dimension_regency' => 'Fk Dimension Regency',
            'fk_dimension_time' => 'Fk Dimension Time',
            'fk_dimension_title' => 'Fk Dimension Title',
            'fk_dimension_unit' => 'Fk Dimension Unit',
            'tables_value' => 'Tables Value',
            'deleted' => 'Deleted',
            'timestamp' => 'Timestamp',
            'timestamp_lastupdate' => 'Timestamp Lastupdate',
        ];
    }
    public function getDimensiontimee()
    {
        return $this->hasOne(DimensionTime::className(), ['id_dimension_time' => 'fk_dimension_time']);
    }
    public function getDimensiontitlee()
    {
        return $this->hasOne(DimensionTitle::className(), ['id_dimension_title' => 'fk_dimension_title']);
    }
    public function getDimensionunite()
    {
        return $this->hasOne(DimensionUnit::className(), ['id_dimension_unit' => 'fk_dimension_unit']);
    }
    public function getDimensionprovincee()
    {
        return $this->hasOne(DimensionProvince::className(), ['id_dimension_province' => 'fk_dimension_province']);
    }
    public function getDimensionregencye()
    {
        return $this->hasOne(DimensionRegency::className(), ['id_dimension_regency' => 'fk_dimension_regency']);
    }
}
