<?php

namespace Drupal\weather\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class WeatherForm extends FormBase {

    public function buildForm(array $form, FormStateInterface $form_state) {

        $connection = \Drupal::database();

        $this->generateInformation($connection);

        $options = $this->loadOptions($connection);

        // Select.
        $form['favorite'] = [
            '#type' => 'select',
            '#title' => $this->t('City to check'),
            '#options' => $options,
        ];

        $form['actions'] = [
            '#type' => 'actions',
        ];
        $form['actions']['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
        ];

        return $form;
    }
    public function getFormId() {
        return 'hello_form';
    }
    public function validateForm(array &$form, FormStateInterface $form_state) {
        $job_title = $form_state->getValue('job_title');
        if (strlen($job_title) < 5) {
            // Set an error for the form element with a key of "title".
            $form_state->setErrorByName('job_title', $this->t('Your job title must be at least 5 characters long.'));
        }
    }
    public function submitForm(array &$form, FormStateInterface $form_state) {
        /*
        * This would normally be replaced by code that actually does something
        * with the title.
        */
        $job_title = $form_state->getValue('job_title');
        drupal_set_message(t('You specified a job title of %job_title.', ['%job_title' => $job_title]));
    }

    private function loadOptions(&$connection)
    {
        $result = $connection->query("SELECT * FROM {city}");

        $options = array();

        foreach ($result as $record) {
            $options[$record->city_name.','.$record->country_code] = $record->city_name;
        }

        return $options;
    }

    private function generateInformation(&$connection)
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
    
}