<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cities".
 *
 * @property int $ID
 * @property string $CITY
 * @property string $COORDS_LATITUDE
 * @property string $COORDS_LONGITUDE
 */
class Cities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CITY', 'COORDS_LATITUDE', 'COORDS_LONGITUDE'], 'required'],
            [['CITY', 'COORDS_LATITUDE', 'COORDS_LONGITUDE'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'CITY' => 'City',
            'COORDS_LATITUDE' => 'Coords Latitude',
            'COORDS_LONGITUDE' => 'Coords Longitude',
        ];
    }
}
