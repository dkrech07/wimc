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
class HistoryIP extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'history_ip';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['history_dt_add_ip'], 'required'],
            [['history_ip'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'history_dt_add_ip' => 'Dt Add',
            'history_ip' => 'ip',
        ];
    }
}
