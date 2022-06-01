<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "history_geocoder".
 *
 * @property int $ID
 * @property string $HISTORY_DT_ADD
 * @property string|null $REQUEST_TEXT_GEOCODER
 * @property string|null $RESPONSE_TEXT_GEOCODER
 */
class HistoryGeocoder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'history_geocoder';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['HISTORY_DT_ADD'], 'required'],
            [['HISTORY_DT_ADD'], 'safe'],
            [['REQUEST_TEXT_GEOCODER', 'RESPONSE_TEXT_GEOCODER'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'HISTORY_DT_ADD' => 'History Dt Add',
            'REQUEST_TEXT_GEOCODER' => 'Request Text Geocoder',
            'RESPONSE_TEXT_GEOCODER' => 'Response Text Geocoder',
        ];
    }
}
