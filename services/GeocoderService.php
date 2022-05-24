<?php

namespace app\services;

use Yii;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;

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
        $result = [];
        foreach ($responseData as $item) {

            // $geocode = trim(",", $geocode);

            $geocode_array = explode(" ", $geocode);
            $geocode_array_search = [];
            foreach ($geocode_array as $code) {
                $geocode_array_search[] = str_replace(",", '', $code);
            }

            $display_name = explode(",", $item->display_name);
            $display_name_reversed = array_reverse($display_name);
            $display_name_reversed[0] = str_replace(" ", '', $display_name_reversed[0]);

            foreach ($geocode_array_search as $geocode_search_item) {

                foreach ($display_name_reversed as $revesed_number => $reversed_item) {
                    if ($geocode_search_item == $reversed_item) {
                        $display_name_reversed[$revesed_number] = '<b>' . $reversed_item . '</b>';
                    }
                }
            }

            $result[] = [
                'display_name' => $display_name_reversed, //$item->display_name,
                'lat' => $item->lat,
                'lon' => $item->lon,
            ];
        }

        // print_r($responseData);
        // print_r($responseData[3]);
        // print_r($responseData[10]->lat);
        // print_r($responseData[10]->lon);

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
