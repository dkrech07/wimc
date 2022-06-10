<?php

namespace app\services;

use Yii;
use app\models\User;
use app\models\Customs;
use app\models\CustomEditForm;
use app\models\Pages;
use app\models\PageEditFormModel;
use app\models\CustomSearchForm;
use app\services\HelperService;

class GrandmasterService
{
    public function getEditPage($id)
    {
        $pageEditFormModel = new PageEditFormModel();

        $editPage = Pages::find()
            ->where(['page_url' => $id])
            ->one();

        $pageEditFormModel->id = $editPage->id;
        $pageEditFormModel->page_dt_add = $editPage->page_dt_add;
        $pageEditFormModel->page_name = $editPage->page_name;
        $pageEditFormModel->page_content = $editPage->page_content;
        $pageEditFormModel->page_user_change = $editPage->page_user_change;
        $pageEditFormModel->page_url = $editPage->page_url;

        return $pageEditFormModel;
    }

    public function editPage(PageEditFormModel $pageEditFormModel)
    {
        $editPage = Pages::find()
            ->where(['id' => $pageEditFormModel->id])
            ->one();

        $editPage->page_dt_add = (new HelperService())->getCurrentDate();
        $editPage->page_name = $pageEditFormModel->page_name;
        $editPage->page_content = $pageEditFormModel->page_content;
        $editPage->page_user_change = Yii::$app->user->identity->login;
        $editPage->page_url = $pageEditFormModel->page_url;

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $editPage->save();
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
        }
    }

    public function getEditCustom($data)
    {
        $customEditFormModel = new CustomEditForm;

        $editCustom = Customs::find()
            ->where(['ID' => $data])
            ->one();

        $customEditFormModel->ID = $editCustom->ID;
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

    public function editCustom(CustomEditForm $customEditFormModel)
    {
        $editCustom = Customs::find()
            ->where(['ID' => $customEditFormModel->ID])
            ->one();

        $editCustom->CODE = $customEditFormModel->CODE;
        $editCustom->NAMT = $customEditFormModel->NAMT;
        $editCustom->OKPO = $customEditFormModel->OKPO;
        $editCustom->OGRN = $customEditFormModel->OGRN;
        $editCustom->INN = $customEditFormModel->INN;
        $editCustom->NAME_ALL = $customEditFormModel->NAME_ALL;
        $editCustom->ADRTAM = $customEditFormModel->ADRTAM;
        $editCustom->PROSF = $customEditFormModel->PROSF;
        $editCustom->TELEFON = $customEditFormModel->TELEFON;
        $editCustom->FAX = $customEditFormModel->FAX;
        $editCustom->EMAIL = $customEditFormModel->EMAIL;
        $editCustom->COORDS_LATITUDE = $customEditFormModel->COORDS_LATITUDE;
        $editCustom->COORDS_LONGITUDE = $customEditFormModel->COORDS_LONGITUDE;

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $editCustom->save();
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
        }
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

    public function getSearchCusom(CustomSearchForm $customSearchFormModel)
    {
        // print('ok');
        // print('ok');
        // print('ok');
        // print('ok');
        // print('ok');
        // print('ok');
        // exit;

        // $search_keys = [];
        // trim($customSearchFormModel->CODE);
        // trim($customSearchFormModel->NAMT);

        // User::find()->andWhere(['like', 'username', '89'])->all();
        // SQL: `username` LIKE '89'

        if ($customSearchFormModel->CODE && $customSearchFormModel->NAMT) {
            // return "SELECT * FROM customs WHERE CODE LIKE " . $code . " AND NAMET LIKE " . $name;
            return Customs::find()->andWhere(['like', 'CODE', $customSearchFormModel->CODE]);
        } else if ($customSearchFormModel->CODE) {
            // return "SELECT * FROM customs WHERE CODE LIKE " . $code;
            return Customs::find()->andWhere(['like', 'CODE', $customSearchFormModel->CODE]);
        } else if ($customSearchFormModel->NAMT) {
            // return "SELECT * FROM customs WHERE NAMET LIKE " . $name;
            return Customs::find()->andWhere(['like', 'NAMT', $customSearchFormModel->NAMT]);
        }


        // $sql = "SELECT * FROM customs";

        // SELECT * FROM gifs // WHERE name LIKE 'рыб%'

    }
}
