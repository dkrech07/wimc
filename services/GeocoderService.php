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
    /**
     * @param string $geocode
     * 
     * @return array
     */
    public function getCoords(string $geocode): array
    {
        $client = new Client([
            'base_uri' => 'https://geocode-maps.yandex.ru/1.x/',
        ]);

        try {
            $request = new Request('GET', '');
            $response = $client->send($request, [
                'query' => [
                    'geocode' => $geocode,
                    'apikey' => Yii::$app->params['geocoderApiKey'],
                    'format' => 'json'
                ]
            ]);

            if ($response->getStatusCode() !== 200) {
                throw new BadResponseException("Response error: " . $response->getReasonPhrase(), $request);
            }

            $content = $response->getBody()->getContents();
            $responseData = json_decode($content, false);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new ServerException('Invalid json format', $request);
            }

            $geoMembers = $responseData->response->GeoObjectCollection->featureMember;
            $result = [];

            foreach ($geoMembers as $geoMemberNumber => $geoMember) {
                $geoObject = $geoMember->GeoObject;
                $GeocoderMetaData = $geoObject->metaDataProperty->GeocoderMetaData;

                $components = $GeocoderMetaData->Address->Components;
                $locality = array_values(array_filter($components, function ($city) {
                    return $city->kind === 'locality';
                }))[0] ?? null;

                $result[$geoMemberNumber] = [
                    'city' => $locality->name ?? null, // Получаю название города, если оно найдено;
                    'text' => $GeocoderMetaData->text, // Получаю подробную информацию о расположении города;
                    'pos' => explode(' ', $geoObject->Point->pos), // Получаю координаты города;
                ];
            }
        } catch (RequestException $ex) {
            $result = [];
        }

        return $result;
    }
}
