<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "history_ip".
 *
 * @property int $id
 * @property string $history_dt_add_ip
 * @property string|null $history_ip
 */
class HistoryIp extends \yii\db\ActiveRecord
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
            [['history_dt_add_ip'], 'safe'],
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
            'history_dt_add_ip' => 'History Dt Add Ip',
            'history_ip' => 'History Ip',
        ];
    }
}
