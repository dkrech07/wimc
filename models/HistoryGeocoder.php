<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "history_geocoder".
 *
 * @property int $id
 * @property string $history_dt_add_geocoder
 * @property string|null $request_text_geocoder
 * @property string|null $response_text_geocoder
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
            [['history_dt_add_geocoder'], 'required'],
            [['history_dt_add_geocoder'], 'safe'],
            [['request_text_geocoder', 'response_text_geocoder'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'history_dt_add_geocoder' => 'History Dt Add',
            'request_text_geocoder' => 'Request Text Geocoder',
            'response_text_geocoder' => 'Response Text Geocoder',
        ];
    }
}
