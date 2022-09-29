<?php

namespace Drupal\student_registration\Form;

// use Drupal\Core\Ajax\InvokeCommand;
use Drupal;
use \Drupal\node\Entity\Node;
use Drupal\Core\Form\FormBase;
use Drupal\node\NodeInterface;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Form\FormStateInterface;



class RegistrationForm extends FormBase
{

  public function getFormId()
  {
    return 'student_registration_form';
  }
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $form['message'] = [
      '#type' => 'markup',
      '#markup' => '<div class="result_message"></div>',
    ];
    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => t('Enter Name:'),
      '#required' => TRUE,
    );
    $form['email'] = array(
      '#type' => 'email',
      '#title' => t('Enter Email ID:'),
      '#required' => TRUE,
      '#ajax' => array(
        'callback' => '_mymodule_ajax',
      ),
    );
    $form['number'] = array(
      '#type' => 'textfield',
      '#title' => t('Enter Phoneno'),
      '#required' => TRUE,
    );
    $form['profile'] = array(
      '#type' => 'textfield',
      '#title' => t('Enter Profile'),
      '#required' => TRUE,
    );
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#ajax' => [
        'callback' => '::setMessage',
        'validate_first' => TRUE,
        'event' => 'change',
      ],
    );
    return $form;
  }
  public static function validateEmail(&$element, FormStateInterface $form_state, &$complete_form) {
    $value = trim($element['#value']);
    $form_state
      ->setValueForElement($element, $value);
    if ($value !== '' && !\Drupal::service('email.validator')
      ->isValid($value)) {
      $form_state
        ->setError($element, t('The email address %mail is not valid.', array(
        '%mail' => $value,
      )));
    }
  }

  public function setMessage(array $form, FormStateInterface $form_state)
  {
    $response = new AjaxResponse();
    $response->addCommand(
      new HtmlCommand(
        '.result_message',
        '<div class="my_message">Done!! </div>'
      )
    );
    return $response;
  }
 
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $node = Node::create(array(
      'type' => 'add_candidate',
      'title' => $form_state->getValue('name'),
      'field_name' => $form_state->getValue('name'),
      'field_email' => $form_state->getValue('email'),
      'field_phoneno' => $form_state->getValue('number'),
      'field_profile' => $form_state->getValue('profile'),
    ));
    $node->save();

  }
}


