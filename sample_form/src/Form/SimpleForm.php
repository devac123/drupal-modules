<?php
/*
-> Provide submit message to the user 
 https://www.drupal.org/docs/drupal-apis/form-api/introduction-to-form-api

-> how to create update node programatically in drupal
https://drupalbook.org/drupal/       9112-add-update-delete-entity-programmatically#:~:text=Create%20node%20programmatically,is%20only%20the%20Title%20field.
*/

/**
 * @file
 * Contains \Drupal\resume\Form\ResumeForm.
 */

namespace Drupal\sample_form\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

use \Drupal\node\Entity\Node;


class SimpleForm extends FormBase {

        /**
         * {@inheritdoc}
         */

      public function getFormId() {
        return 'Add User';
      }
        /**
        * {@inheritdoc}
        */

      public function buildForm(array $form, FormStateInterface $form_state) {
        $form['user'] = [
          '#type' => 'textfield',
          '#title' => $this->t('Autocomplete Articles'),
          '#autocomplete_route_name' => 'mymodule.autocomplete',
      
        $form['submit'] = [
          '#type' => 'submit',
          '#value' => $this->t('Submit')
        ];

        return $form;
      }
       


      public function validateForm(array &$form, FormStateInterface $form_state) {

       
      }

      public function submitForm(array &$form, FormStateInterface $form_state) {
         
        $this->messenger()->addStatus($this->t($form_state->getValue('prod_name').' '.' Node Has been created Successfully'));
   
      }

        
    
}