<?php

namespace app\services;

use Yii;
use app\models\User;
use app\models\Customs;
use app\models\CustomEditForm;

class GrandmasterService
{
    public function editCustom($data)
    {
        $customEditFormModel = new CustomEditForm;

        $editCustom = Customs::find()
            ->where(['ID' => $data])
            ->one();

        $customEditFormModel->CODE = $editCustom->CODE;
        $customEditFormModel->NAMT = $editCustom->NAMT;
        $customEditFormModel->OKPO = $editCustom->OKPO;
        $customEditFormModel->OGRN = $editCustom->OGRN;
        $customEditFormModel->INN = $editCustom->INN;
        $customEditFormModel->NAME_ALL = $editCustom->NAME_ALL;
        $customEditFormModel->ADRTAM = $editCustom->ADRTAM;
        $customEditFormModel->PROSF = $editCustom->PROSF;
        $customEditFormModel->TELEFON = $editCustom->TELEFON;
        $customEditFormModel->FAX = $editCustom->FAX;
        $customEditFormModel->EMAIL = $editCustom->EMAIL;
        $customEditFormModel->COORDS_LATITUDE = $editCustom->COORDS_LATITUDE;
        $customEditFormModel->COORDS_LONGITUDE = $editCustom->COORDS_LONGITUDE;

        return $customEditFormModel;
    }


    public function getСustoms()
    {
        $query = Customs::find();
        // ->joinWith('category')
        // ->where(['tasks.status' => 'new'])
        // ->orderBy('dt_add DESC');

        // if ($model->categories) {
        //     $query->andWhere(['in', 'category_id', $model->categories]);
        // }

        // if ($model->without_executor) {
        //     $query->andWhere(['executor_id' => null]);
        // }

        // settype($model->period, 'integer');
        // if ($model->period > 0) {
        //     $exp = new Expression("DATE_SUB(NOW(), INTERVAL {$model->period} HOUR)");
        //     $query->andWhere(['>', 'dt_add', $exp]);
        // }

        return $query;
    }
}
