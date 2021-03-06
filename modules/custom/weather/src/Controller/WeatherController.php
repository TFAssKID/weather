<?php
namespace Drupal\weather\Controller;
use Drupal\Core\Controller\ControllerBase;
use GuzzleHttp\Exception\ClientException;

class WeatherController extends ControllerBase {

    public function checkWeather($url, array $parameters, $appid)
    {
        try {

            $client = \Drupal::httpClient();
            $request = $client->get(
                $this->createUrl($url, $parameters, $appid)
            );
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

    public function checkWeatherByCoo()
    {
        return $this->checkWeather(
            'http://api.openweathermap.org/data/2.5/weather',
            array('lat'=> 35, 'lon' => 139),
            'f7f726dac4af70b5f506886e2f8c7c70'
        );

    }

    private function renderTable(array $resp)
    {
        $table = <<< TABLE
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
TABLE;

        return $table;
    }

    public function loadOptions(&$connection)
    {
        $result = $connection->query("SELECT * FROM {city}");

        $options = array();

        foreach ($result as $record) {
            $options[$record->city_name.','.$record->country_code] = $record->city_name;
        }

        return $options;
    }

    public function generateInformation(&$connection)
    {
        $result = $connection->query("SELECT * FROM {city}");
        $records = $result->fetchAll();
        $num_results = count($records);

        if($num_results === 0)
        {
            $values = [
                [
                    'city_name' => 'Bogota',
                    'country_code' => 'co',
                ],
                [
                    'city_name' => 'London',
                    'country_code' => 'uk',
                ],
                [
                    'city_name' => 'Cali',
                    'country_code' => 'co',
                ],
                [
                    'city_name' => 'Miami',
                    'country_code' => 'us',
                ],
            ];

            $query = $connection->insert('city')->fields(['city_name', 'country_code']);

            foreach ($values as $record) {
                $query->values($record);
            }

            $query->execute();
        }
    }

    private function createUrl($url, array $parameters, $appid)
    {
        $all = $url.'?'.'appid='.$appid;
        foreach ($parameters as $key => $value) {
            $all .='&'. $key.'='.$value;
        }
        return $all;
    }
}