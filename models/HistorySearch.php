<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "history_search".
 *
 * @property int $ID
 * @property string $HISTORY_DT_ADD
 * @property string|null $REQUEST_TEXT_SEARCH
 * @property string|null $RESPONSE_TEXT_SEARCH
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
            [['HISTORY_DT_ADD'], 'required'],
            [['HISTORY_DT_ADD'], 'safe'],
            [['REQUEST_TEXT_SEARCH', 'RESPONSE_TEXT_SEARCH'], 'string', 'max' => 256],
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
            'REQUEST_TEXT_SEARCH' => 'Request Text Search',
            'RESPONSE_TEXT_SEARCH' => 'Response Text Search',
        ];
    }
}
