<?php
namespace Drupal\custom_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\node\Entity\Node;


class Normal_Form extends FormBase 
{
    
    public function getFormId() {
        return 'form_id';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
        $form['username'] = array(
          '#type' => 'textfield',
          '#title' => t('Enter username:'),
          '#required' => TRUE,
        );
        $form['useremail'] = array(
          '#type' => 'email',
          '#title' => t('Enter Email ID:'),
          '#required' => TRUE,
        );
        $form['user_phone'] = array (
          '#type' => 'tel',
          '#title' => t('Enter Contact Number'),
        );
        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = array(
          '#type' => 'submit',
          '#value' => $this->t('Register'),
        );
        $form['message'] = [
            '#type' => 'markup',
            '#markup' => '<div class="result_message"></div>',
        ];
        return $form;
       
      }
        public function validateForm(array &$form, FormStateInterface $form_state) {
        if(strlen($form_state->getValue('username')) < 3) {
          $form_state->setErrorByName('username', $this->t('Please enter a valid Name'));
        }
        if(strlen($form_state->getValue('user_phone')) < 10) {
          $form_state->setErrorByName('user_phone', $this->t('Please enter a valid Contact Number'));
        }
      }
      public function submitForm(array &$form, FormStateInterface $form_state) 
      {
        // $service = \Drupal::service('services.say_hello');
        // dd($service->sayHello('parkash'));
        $service = \Drupal::service('services.say_hello');
        dd($service);
          $name=$form_state->getvalue(['username']);
          $email=$form_state->getvalue(['useremail']);
          $phone=$form_state->getvalue(['user_phone']);
          $x = array();
          $x[] = $name;
          $x[] = $email;
          $x[] = $phone;
          $output= implode(",",$x);
          
          $node = Node::create([
            'type'  => 'clothes',
            'title' => $name,
            'body' => $output,
          ]);
          $node->save();
      }

}
?>