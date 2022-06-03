<?php

namespace app\models;

use yii\base\Model;

/**
 * This is the model class for table "CustomEditForm".
 *
 * @property int $ID
 * @property int $CODE
 * @property string $NAMT
 * @property int $OKPO
 * @property int $OGRN
 * @property int $INN
 * @property string $NAME_ALL
 * @property string $ADRTAM
 * @property int $PROSF
 * @property string $TELEFON
 * @property string $FAX
 * @property string $EMAIL
 * @property string $COORDS_LATITUDE
 * @property string $COORDS_LONGITUDE
 */
class CustomEditForm extends Model
{
    public $CODE;
    public $NAMT;
    public $OKPO;
    public $OGRN;
    public $INN;
    public $NAME_ALL;
    public $ADRTAM;
    public $PROSF;
    public $TELEFON;
    public $FAX;
    public $EMAIL;
    public $COORDS_LATITUDE;
    public $COORDS_LONGITUDE;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['CODE', 'NAMT', 'OKPO', 'OGRN', 'INN', 'NAME_ALL', 'ADRTAM', 'PROSF', 'TELEFON', 'FAX', 'EMAIL', 'COORDS_LATITUDE', 'COORDS_LONGITUDE'], 'required'],
            // [['CODE', 'OKPO', 'OGRN', 'INN', 'PROSF'], 'integer'],
            [['CODE', 'NAMT', 'OKPO', 'OGRN', 'INN', 'NAME_ALL', 'ADRTAM', 'PROSF', 'TELEFON', 'FAX', 'EMAIL', 'COORDS_LATITUDE', 'COORDS_LONGITUDE'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'CODE' => 'Code',
            'NAMT' => 'Namt',
            'OKPO' => 'Okpo',
            'OGRN' => 'Ogrn',
            'INN' => 'Inn',
            'NAME_ALL' => 'Name All',
            'ADRTAM' => 'Adrtam',
            'PROSF' => 'Prosf',
            'TELEFON' => 'Telefon',
            'FAX' => 'Fax',
            'EMAIL' => 'Email',
            'COORDS_LATITUDE' => 'Coords Latitude',
            'COORDS_LONGITUDE' => 'Coords Longitude',
        ];
    }
}
