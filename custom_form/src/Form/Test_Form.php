<?php
namespace Drupal\custom_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\node\Entity\Node;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\ChangedCommand;

class Test_Form extends FormBase 
{

    private $submit = false;
    
    public function getFormId() {
        return 'form_id';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
        $form['username'] = array(
          '#type' => 'textfield',
          '#title' => 'Enter username:',
          '#required' => TRUE,
          '#ajax' => array(
            'callback' => 'Drupal\custom_form\Form\Test_Form::usernameValidateCallback',
            'effect' => 'fade',
            'event' => 'change',
            'progress' => [
              'type' => 'throbber',
              'message' => NULL,
            ]
          )
            
        
        );
        $form['useremail'] = array(
          '#type' => 'email',
          '#title' => 'Enter Email ID:',
          '#required' => TRUE,
        );
        $form['user_phone'] = array (
          '#type' => 'tel',
          '#title' => 'Enter Contact Number',
        );
        $form['actions']['#type'] = 'actions';
        
        $form['actions']['submit'] = array(
          '#type' => 'submit',
          '#value' => 'Register',
          '#ajax' => [
            'callback' => '::setMessage',
        ],
        );
        $form['message'] = [
            '#type' => 'markup',
            '#markup' => '<div class="result_message"></div>',
        ];
        return $form;
      }
        public function validateForm(array &$form, FormStateInterface $form_state) {
        if(strlen($form_state->getValue('username')) < 3) {
          $form_state->setErrorByName('username', 'Please enter a valid Name');
        }
        if(strlen($form_state->getValue('user_phone')) < 10) {
          $form_state->setErrorByName('user_phone', 'Please enter a valid Contact Number');
        }
      }
      public function setMessage(array $form, FormStateInterface $form_state) 
      {
        // $response = new AjaxResponse();
        //       $response->addCommand(
        //         new HtmlCommand(
        //             '.result_message',
        //             '<div class="my_message">Submitted name is ' . $form_state->getValue('username') . '</div>')
        //         );
            
        // return $response;
     }
      public function submitForm(array &$form, FormStateInterface $form_state) 
      {
        \Drupal::logger('some_channel_name submit')->warning($form_state->getValue('username'));
        if($this->submit == true ){
          \Drupal::messenger()->addStatus('right');
        }
        else{
         
        }
        \Drupal::messenger()->addStatus('wrong');
          // $output =$form_state->getValues();
          // $name=$form_state->getvalue(['username']);
          // $email=$form_state->getvalue(['useremail']);
          // $phone=$form_state->getvalue(['user_phone']);
          // $x = array();
          // $x[] = $name;
          // $x[] = $email;
          // $x[] = $phone;
          // $output= implode(",",$x);
          // $node = Node::create([
          //   'type'  => 'clothes',
          //   'title' => $name,
          //   'body' => $output,
          // ]);
          // $node->save();

          // $ajax_response = new AjaxResponse();

          // $ajax_response->addCommand(new HtmlCommand('#edit-user-name--description', "working"));
          // $ajax_response->addCommand(new InvokeCommand('#edit-user-name--description', 'css', array('color', "green")));


          // return $ajax_response;

      }

      public function usernameValidateCallback(array &$form, FormStateInterface $form_state) {
       
        // Instantiate an AjaxResponse Object to return.
        $ajax_response = new AjaxResponse();
        
        // Check if Username exists and is not Anonymous User ('').
        if (user_load_by_name($form_state->getValue('username')) && $form_state->getValue('username') != false) 
        {
         

          $text = 'User Found';
          $color = 'green';
        } 
        else 
        {
          $this->submit = true;
          $text = 'No User Found';
          $color = 'red';
        }
        
        // Add a command to execute on form, jQuery .html() replaces content between tags.
        // In this case, we replace the desription with wheter the username was found or not.
          $ajax_response->addCommand(new HtmlCommand('#edit-user-name--description', $text));
        
        // Add a command, InvokeCommand, which allows for custom jQuery commands.
        // In this case, we alter the color of the description.
          $ajax_response->addCommand(new InvokeCommand('#edit-user-name--description', 'css', array('color', $color)));
        
        // Return the AjaxResponse Object.
        return $ajax_response;
        }
      






















}
?>