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
        $job_title = $form_state->getValue('job_title');
        if (strlen($job_title) < 5) {
            // Set an error for the form element with a key of "title".
            $form_state->setErrorByName('job_title', $this->t('Your job title must be at least 5 characters long.'));
        }
    }
    public function submitForm(array &$form, FormStateInterface $form_state) {
//
//        $city_code = $form_state->getValue('city');
//
//        $response = new AjaxResponse();
//        $title = 'Node ID';
//        if ($id !== NULL) {
//            $content = '<div class="test-popup-content"> Node ID is: ' . $id . '</div>';
//            $options = array(
//                'dialogClass' => 'popup-dialog-class',
//                'width' => '300',
//                'height' => '300',
//            );
//            $response->addCommand(new OpenModalDialogCommand($title, $content, $options));
//        } else {
//            $content = 'Not found record with this title <strong>' . $node_title .'</strong>';
//            $options = array(
//                'dialogClass' => 'popup-dialog-class',
//                'width' => '300',
//                'height' => '300',
//            );
//            $response->addCommand(new OpenModalDialogCommand($title, $content, $options)); }
//        return $response;
    }

}