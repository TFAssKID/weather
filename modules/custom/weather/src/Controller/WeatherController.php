<?php
namespace Drupal\weather\Controller;
use Drupal\Core\Controller\ControllerBase;
use GuzzleHttp\Exception\ClientException;

class WeatherController extends ControllerBase {

    public function checkWeather()
    {
        try {


            $client = \Drupal::httpClient();
            $request = $client->get('http://api.openweathermap.org/data/2.5/weather?q=London,uk&appid=f7f726dac4af70b5f506886e2f8c7c70');
            $response = json_decode($request->getBody());

            return array(
                '#markup' => "FAIL",
            );
        }
        catch (ClientException $e) {

            return array(
                '#markup' => $e->getMessage(),
            );

        }

    }
}