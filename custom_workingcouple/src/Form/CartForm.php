<?php
/**
 * @file
 * Contains \Drupal\student_registration\Form\RegistrationForm.
 */
namespace Drupal\custom_workingcouple\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Stripe\PaymentMethod;
use Stripe\Customer;
use Drupal\commerce_payment\Entity\PaymentMethodInterface;

class CartForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'cart_form';
  }
  
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => t('Username'),
      '#required' => TRUE,
      '#value' => 'test'
    );
    $form['email'] = array(
        '#type' => 'textfield',
        '#title' => t('Email ID'),
        '#required' => TRUE,
        '#value' => 'Test@gmail.com'
    );
    $form['cart'] = array(
      '#type' => 'textfield',
      '#title' => t('Cart no.'),
      '#required' => TRUE,
      '#value' => '4242424242424242'
    );

    $form['exp_date'] = array(
        '#type' => 'date',
        '#title' => t('Date'),
        '#required' => TRUE,
    );

    $form['cv'] = array(
    '#type' => 'textfield',
    '#title' => t('CV'),
    '#required' => TRUE,
    '#value' => '123'
    );


    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Register'),
      '#button_type' => 'primary',
    );
    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

    $card_number = $form_state->getValue('cart');
    $expiry = $form_state->getValue('exp_date');
    $card_cvv = $form_state->getValue('cv');
    $mail = $form_state->getValue('email');
    $name = $form_state->getValue('name');
    $expiry_date = explode("-", $expiry);
    $today = time();

    $formValues = $form_state->getValues();

    $stripe = new \Stripe\StripeClient(
'sk_test_51LdSp2SB6w3qfhwfl99z9tj22iSJ8HORVHs4bhU7YBACwGMKAlzROucglw0u9fcwiFSBMDuYgIIds8K7QVZ7hbqq00YgSVB7LR'
    );
    /*  */
    $payment_method = $stripe->paymentMethods->create([
      'type' => 'card',
      'card' => [
          'number' => $card_number,
          'exp_month' => $expiry_date[1],
          'exp_year' => $expiry_date[0],
          'cvc' => $card_cvv,
      ],
    ]); 



    $customer = $stripe->customers->create([
      "name" => "erik",
      "email" => "erik@gmail.com",
      "payment_method" => $payment_method->id,
      "address" => [
        "city" => "Ketchikan",
        "country" => "United States",
        "line1" => "Ketchikan",
        "postal_code" => "99901",
        "state" => "Alaska"
      ]
    ]);

    $stripe_sub = $stripe->subscriptions->create([
      'customer' =>   $customer->id,
      'default_payment_method' => $payment_method->id,
      'items' => [
          ['plan' => 'price_1LhptjSB6w3qfhwfrNFk2BbP'],
      ],
    ]);

    if(isset($stripe_sub->latest_invoice)){
      $stripe->invoices->pay($stripe_sub->latest_invoice, []);
    }
  }

 

}