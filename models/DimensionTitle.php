<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dimension_title".
 *
 * @property int $id_dimension_title
 * @property string $title
 * @property string $title_en
 */
class DimensionTitle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dimension_title';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'title_en'], 'required'],
            [['title', 'title_en'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_dimension_title' => 'Id Dimension Title',
            'title' => 'Title',
            'title_en' => 'Title En',
        ];
    }
}
