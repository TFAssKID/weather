<?php
namespace Drupal\weather\Controller;
use Drupal\Core\Controller\ControllerBase;

class WeatherController extends ControllerBase {

    public function checkWeather()
    {
        //$response= drupal_http_request('http://api.openweathermap.org/data/2.5/weather?q=London,uk&appid=f7f726dac4af70b5f506886e2f8c7c70');

        return array(
            '#markup' => hello_hello_world(),
        );
    }
}