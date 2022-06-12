<?php

namespace app\services;

use Yii;
use app\models\HistorySearch;
use app\services\HelperService;

class LogService
{
    function logGeocoderAdd()
    {
        // $geocode - запрос из поиска
        //  'display_name' => $display_name, //$item->display_name, $display_name_clean
        // 'lat' => $item->lat,
        // 'lon' => $item->lon,
    }
    function logSearch($form_model)
    {
        $historySearch = new HistorySearch();

        $historySearch->history_dt_add_search = (new HelperService())->getCurrentDate();
        $historySearch->history_text_search = $form_model->autocomplete;
        $historySearch->history_latitude = $form_model->latitude;
        $historySearch->history_longitude = $form_model->longitude;
        $historySearch->history_nearest_lat = $form_model->nearest_lat;
        $historySearch->history_nearest_lon = $form_model->nearest_lon;
        $historySearch->history_nearest_code = $form_model->nearest_code;
        // $historySearch->history_distance = $form_model->distance;
        // $historySearch->history_filter = $form_model->filter;

        // 'history_dt_add_search' => $this->dateTime()->notNull(),
        // 'history_text_search' => $this->string(256)->null(),
        // 'history_latitude' => $this->string(256)->null(),
        // 'history_longitude' => $this->string(256)->null(),
        // 'history_nearest_lat' => $this->string(256)->null(),
        // 'history_nearest_lon' => $this->string(256)->null(),
        // 'history_nearest_code' => $this->string(256)->null(),
        // 'history_distance' => $this->string(256)->null(),
        // 'history_filter' => $this->string(256)->null()


        $transaction = Yii::$app->db->beginTransaction();
        try {
            $historySearch->save();
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
        }
    }
}
