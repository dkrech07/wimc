<?php

namespace app\models;

use yii\base\Model;

/**
 * This is the model class for table "CustomEditForm".
 *
 * @property int $CODE
 * @property string $NAMT
 */
class CustomSearchForm extends Model
{
    public $NAMT;
    public $OKPO;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CODE', 'NAMT'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CODE' => 'Code',
            'NAMT' => 'Namt',
        ];
    }
}
