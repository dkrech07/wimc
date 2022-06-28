<?php

namespace app\services;

use Yii;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use app\services\LogService;

class GeocoderService
{
    function getCoords($geocode)
    {
        $query = http_build_query([
            'format' => 'json',
            'q' => $geocode,
            'polygon_geojson' => 1,
        ]);

        $url = "http://nominatim.openstreetmap.org/search?$query";
        $client = new Client([
            'base_uri' => $url,
        ]);

        $request = new Request('PUT', $url);
        $response = $client->send($request);
        $content = $response->getBody()->getContents();
        $responseData = json_decode($content, false);
        // $responseData = json_encode($content);

        // FeatureCollection
        $logResult = [];
        $result = [];
        foreach ($responseData as $item) {

            // Разделяю адрес по запятым и сохраняю слова в массив;
            $display_name = explode(",", $item->display_name);

            // Разворачиваю массив (чтобы страна, город и т.д. были вначале);
            $display_name_reversed = array_reverse($display_name);

            // Сохраняю чистый массив;
            $name_clean = $display_name_reversed;

            // Сохраняю массив для проверки;
            $name_formatted = $display_name_reversed;

            foreach ($name_formatted as $name_formatted_number => $name_formatted_item) {
                $name_formatted[$name_formatted_number] = explode(" ", trim($name_formatted_item));
            }

            // Разделяю запрос пользователя по пробелам и сохраняю слова в массив;
            $geocode_array = explode(" ", $geocode);

            // Удаляю запятые из слов запроса пользователя запятые (для сравнения в будущем);
            foreach ($geocode_array as $geocode_array_number => $geocode_array_item) {
                $geocode_array[$geocode_array_number] = str_replace(",", '', $geocode_array_item);
            }

            // Ищу совпадения;
            foreach ($geocode_array as $geocode_array_number => $geocode_array_item) {
                foreach ($name_formatted as $name_formatted_number => $name_formatted_item) {
                    foreach ($name_formatted_item as $formatted_number => $formatted_item) {
                        if (mb_strtolower($geocode_array_item, 'UTF-8') == mb_strtolower($formatted_item, 'UTF-8')) {
                            $name_formatted[$name_formatted_number][$formatted_number] = '<span style="font-weight: bold; color: #28a745">' . $formatted_item . '</span>';
                        }
                    }
                }
            }

            $name_text = '';

            foreach ($name_formatted as $name_formatted_number => $name_formatted_item) {

                $name_formatted[$name_formatted_number] = implode(" ", $name_formatted_item);

                if ($name_formatted_number > 0) {
                    $name_formatted[$name_formatted_number] = ' ' . $name_formatted[$name_formatted_number];
                }
                // foreach($name_formatted_item as $formatted_number => $formatted_item) {

                // }

            }

            $display_name = [
                'formatted' => $name_formatted,
                'clean' => $name_clean,
            ];

            $result[] = [
                'display_name' => $display_name, //$item->display_name, $display_name_clean
                'lat' => $item->lat,
                'lon' => $item->lon,
            ];



            $logResult[] = implode(',', $display_name['clean']);
        }


        $geocoderCount = 0;
        if (isset($result[0]['display_name'])) {
            $geocoderCount = count($result);
        }
        // mb_strtolower($display_name_reversed_item, 'UTF-8');

        // print_r($responseData);
        // print_r($responseData[3]);
        // print_r($responseData[10]->lat);
        // print_r($responseData[10]->lon);

        (new LogService())->logGeocoder($geocode, $geocoderCount);

        return json_encode($result, JSON_UNESCAPED_UNICODE);

        // $query = http_build_query([
        //     'format' => 'json',
        //     'q' => $geocode,
        //     'polygon_geojson' => 1,
        // ]);



        // $request = new Request('GET', '');

        // $response = $client->send($request, [
        //     'query' => [
        //         'geocode' => $geocode,
        //         'format' => 'json'
        //     ]
        // ]);




        // $url = "http://nominatim.openstreetmap.org/search?$query";

        // $query = http_build_query([
        //     'format' => 'json',
        //     'q' => $geocode,
        //     'polygon_geojson' => 1,
        // ]);
        // $url = "http://nominatim.openstreetmap.org/search?$query";
        // $response = json_decode(file_get_contents($url), true);

        // $response = json_decode($url, false);

        // $response = json_decode(file_get_contents($url), true);
        // $result = [];

        // if ($response[0]['geojson']['type'] === 'MultiPolygon') {
        //     $coords = $response[0]['geojson']['coordinates'];
        //     foreach ($coords as $coord) {
        //         $temp = [];
        //         foreach ($coord[0] as $item) {
        //             $temp[] = array_reverse($item);
        //         }
        //         $result[] = $temp;
        //     }
        // } elseif ($response[0]['geojson']['type'] === 'Polygon') {
        //     $coords = $response[0]['geojson']['coordinates'][0];
        //     foreach ($coords as $coord) {
        //         $result[] = array_reverse($coord);
        //     }
        // }

        // return $result;

    }

    // echo json_encode(areaCoordsParser('Адмиралтейский район, Санкт-Петербург'));
}
