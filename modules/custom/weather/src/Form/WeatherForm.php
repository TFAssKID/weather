<?php

namespace Drupal\weather\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\weather\Controller\WeatherController;

class WeatherForm extends FormBase {

    public function buildForm(array $form, FormStateInterface $form_state) {

        $weather = new WeatherController;

        $connection = \Drupal::database();

        $weather->generateInformation($connection);

        $options = $weather->loadOptions($connection);

        $form['#attached']['library'][] = 'core/drupal.dialog.ajax';

        // Select.
        $form['city'] = [
            '#type' => 'select',
            '#title' => $this->t('City to check'),
            '#options' => $options,
        ];

        $form['actions'] = [
            '#type' => 'actions',
        ];
        $form['actions']['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Consult'),
            '#ajax' => array( // here we add Ajax callback where we will process
                'callback' => '::open_modal', // the data that came from the form and that we will receive as a result in the modal window
            ),
        ];

        return $form;
    }
    public function getFormId() {
        return 'hello_form';
    }
    public function validateForm(array &$form, FormStateInterface $form_state) {

    }
    public function submitForm(array &$form, FormStateInterface $form_state)
    {

    }

    public function open_modal(array &$form, FormStateInterface $form_state)
    {
        $weather = new WeatherController;

        $city_code = $form_state->getValue('city');

        $weather_status = $weather->checkWeather(
            'http://api.openweathermap.org/data/2.5/weather',
            array('q' => $city_code),
            'f7f726dac4af70b5f506886e2f8c7c70'
        );

        $ajax_response = new AjaxResponse();
        $title = 'Weather Result';

        $content = '<div class="test-popup-content">'.$weather_status['#markup'].'</div>';
        $options = array(
            'dialogClass' => 'popup-dialog-class',
            'width' => '300',
            'height' => '300',
        );
        $ajax_response->addCommand(new OpenModalDialogCommand($title, $content, $options));

        return $ajax_response;
    }


}