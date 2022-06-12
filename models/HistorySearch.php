<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "history_search".
 *
 * @property int $id
 * @property string $history_dt_add_search
 * @property string|null $history_text_search
 * @property string|null $history_latitude
 * @property string|null $history_longitude
 * @property string|null $history_nearest_lat
 * @property string|null $history_nearest_lon
 * @property string|null $history_nearest_code
 * @property string|null $history_distance
 * @property string|null $history_filter
 */
class HistorySearch extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'history_search';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['history_dt_add_search'], 'required'],
            [['history_dt_add_search'], 'safe'],
            [['history_text_search', 'history_latitude', 'history_longitude', 'history_nearest_lat', 'history_nearest_lon', 'history_nearest_code', 'history_distance', 'history_filter'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'history_dt_add_search' => 'History Dt Add Search',
            'history_text_search' => 'History Text Search',
            'history_latitude' => 'History Latitude',
            'history_longitude' => 'History Longitude',
            'history_nearest_lat' => 'History Nearest Lat',
            'history_nearest_lon' => 'History Nearest Lon',
            'history_nearest_code' => 'History Nearest Code',
            'history_distance' => 'History Distance',
            'history_filter' => 'History Filter',
        ];
    }
}
