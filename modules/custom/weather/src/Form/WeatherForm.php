<?php

namespace Drupal\weather\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class WeatherForm extends FormBase {

    public function buildForm(array $form, FormStateInterface $form_state) {

        // Select.
        $form['favorite'] = [
            '#type' => 'select',
            '#title' => $this->t('City to check'),
            '#options' => [
                'Bogota,co' => $this->t('Bogota'),
                'London,uk' => $this->t('London'),
                'Miami,us' => $this->t('Miami'),
            ],
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
    
}