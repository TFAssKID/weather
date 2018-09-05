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
            $response = json_decode($request->getBody(), true);

            return array(
                '#markup' => $this->renderTable($response),
            );
        }
        catch (ClientException $e) {

            return array(
                '#markup' => $e->getMessage(),
            );

        }

    }

    private function renderTable(array $resp)
    {
        $table = <<< LINCOLN
        <h1>{$resp['name']}</h1>
        <table>
                <tbody>
                    <tr>
                        <th>Features</th>
                        <th>Value</th>
                    </tr>
                    <tr>
                        <td>Temp</td>
                        <td> {$resp['main']['temp']} </td>
                    </tr>
                    <tr>
                        <td>Pressure</td>
                        <td> {$resp['main']['pressure']} </td>
                    </tr>
                    <tr>
                        <td>Humidity</td>
                        <td> {$resp['main']['humidity']} </td>
                    </tr>
	            </tbody>
               </table>
LINCOLN;

        return $table;
    }


}